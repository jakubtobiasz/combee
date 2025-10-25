<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Model;

use Recode\Ecommerce\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\Exception\OrderSealedException;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Ordering\Model\AddItemStrategy\MergeSameSkuItemsStrategy;
use Recode\Ecommerce\Core\Shared\Contract\Collection;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

class Order implements OrderContract
{
    public protected(set) bool $isSealed {
        get {
            if (!isset($this->isSealed)) {
                $this->isSealed = $this->state !== 'cart';
            }

            return $this->isSealed;
        }
    }

    /**
     * @param Collection<array-key, OrderItemContract> $items
     */
    public function __construct(
        public readonly OrderIdentifier $uuid,
        public Collection $items {
            get => $this->items;
        },
        protected(set) string $state = 'cart' {
            get => $this->state;
            set => $this->state = $value;
        }
    ) {
    }

    public function addItem(OrderItemContract $item, AddItemStrategyContract $addItemStrategy = new MergeSameSkuItemsStrategy()): void
    {
        OrderSealedException::throwIfTrue($this->isSealed);

        $addItemStrategy->addItem($this->items, $item);
    }
}
