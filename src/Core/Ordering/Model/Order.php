<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Model;

use Combee\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Combee\Core\Ordering\Contract\Model\Exception\OrderSealedException;
use Combee\Core\Ordering\Contract\Model\OrderContract;
use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Combee\Core\Shared\Contract\Collection;
use Combee\Core\Shared\Model\Identifier\OrderIdentifier;

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

    public function addItem(OrderItemContract $item, AddItemStrategyContract $addItemStrategy): void
    {
        OrderSealedException::throwIfTrue($this->isSealed);

        $addItemStrategy->addItem($this->items, $item);
    }
}
