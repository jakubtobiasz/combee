<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Model;

use Recode\Ecommerce\Core\Ordering\Contract\Exception\NegativeOrZeroUnitPriceException;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Ordering\Model\Exception\NegativeOrZeroQuantityException;
use Recode\Ecommerce\Core\Shared\Collection\ArrayCollection;
use Recode\Ecommerce\Core\Shared\Contract\Collection;
use Recode\Ecommerce\Core\Shared\Contract\PriceAdjustmentContract;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderItemIdentifier;

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
        OrderItemIdentifier $uuid,
        string $productSku,
        Price $unitPrice,
        int $quantity,
        Collection $priceAdjustments = new ArrayCollection(),
    ) {
        $this->uuid = $uuid;
        $this->productSku = $productSku;
        $this->unitPrice = $unitPrice;
        $this->quantity = $quantity;
        $this->_priceAdjustments = $priceAdjustments;
    }

    public OrderItemIdentifier $uuid {
        get => $this->uuid;
    }

    public string $productSku {
        get => $this->productSku;
    }

    public int $quantity {
        get => $this->quantity;
        set {
            NegativeOrZeroQuantityException::throwIfNegativeOrZero($value);

            $this->quantity = $value;
            $this->forcePriceRecalculation = true;
        }
    }

    public Price $unitPrice {
        get => $this->unitPrice;
        set {
            NegativeOrZeroUnitPriceException::throwIfNotPositive($value);

            $this->unitPrice = $value;
            $this->forcePriceRecalculation = true;
        }
    }

    public Price $price {
        get {
            if (isset($this->price) && !$this->forcePriceRecalculation) {
                return $this->price;
            }

            return $this->price = $this->calculatePrice();
        }
        set {
            NegativeOrZeroUnitPriceException::throwIfNotPositive($value);

            $this->price = $value;
            $this->forcePriceRecalculation = true;
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
