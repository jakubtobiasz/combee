<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Model;

use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Combee\Core\Ordering\Model\Exception\NegativeOrZeroQuantityException;
use Combee\Core\Shared\Collection\ArrayCollection;
use Combee\Core\Shared\Contract\Collection;
use Combee\Core\Shared\Contract\PriceAdjustmentContract;
use Combee\Core\Shared\DataObject\Price;
use Combee\Core\Shared\Model\Identifier\OrderItemIdentifier;

class OrderItem implements OrderItemContract
{
    protected bool $forcePriceRecalculation = false;

    protected bool $forceAdjustmentsReload = false;

    /** @var Collection<array-key, PriceAdjustmentContract> */
    protected readonly Collection $_priceAdjustments;

    /**
     * @param Collection<array-key, PriceAdjustmentContract> $priceAdjustments
     */
    public function __construct(
        public readonly OrderItemIdentifier $uuid,
        public readonly string $productSku,
        public readonly Price $unitPrice,
        public int $quantity {
            get => $this->quantity;
            set {
                NegativeOrZeroQuantityException::throwIfNegativeOrZero($value);

                $this->quantity = $value;
                $this->forcePriceRecalculation = true;
            }
        },
        Collection $priceAdjustments = new ArrayCollection(),
    ) {
        $this->_priceAdjustments = $priceAdjustments;
    }

    public Price $price {
        get {
            if (isset($this->price) && !$this->forcePriceRecalculation) {
                return $this->price;
            }

            return $this->price = $this->calculatePrice();
        }
    }

    /** @inheritdoc */
    public Collection $priceAdjustments {
        get {
            if (isset($this->priceAdjustments) && !$this->forceAdjustmentsReload) {
                return $this->priceAdjustments;
            }

            $this->forceAdjustmentsReload = false;

            return $this->priceAdjustments = clone $this->_priceAdjustments;
        }
    }

    public function addPriceAdjustment(PriceAdjustmentContract $priceAdjustment): void
    {
        if ($this->_priceAdjustments->contains($priceAdjustment)) {
            return;
        }

        $this->_priceAdjustments->add($priceAdjustment);

        $this->forceAdjustmentsReload = true;
        $this->forcePriceRecalculation = true;
    }

    public function removePriceAdjustment(PriceAdjustmentContract $priceAdjustment): void
    {
        if (!$this->_priceAdjustments->contains($priceAdjustment)) {
            return;
        }

        $this->_priceAdjustments->removeElement($priceAdjustment);

        $this->forceAdjustmentsReload = true;
        $this->forcePriceRecalculation = true;
    }

    protected function calculatePrice(): Price
    {
        $newPrice = $this->unitPrice->multiply($this->quantity);

        $adjustmentAmounts = $this->_priceAdjustments->map(
            fn (PriceAdjustmentContract $priceAdjustment): Price => $priceAdjustment->amount,
        );
        $newPrice = $newPrice->add(...$adjustmentAmounts->toArray());

        $this->forcePriceRecalculation = false;

        return $newPrice;
    }
}
