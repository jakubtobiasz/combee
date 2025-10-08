<?php declare(strict_types=1);

namespace Combee\Ordering\Model;

use Combee\Core\Model\Identifier\OrderIdentifier;
use Combee\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Combee\Ordering\Contract\Model\Exception\OrderSealedException;
use Combee\Ordering\Contract\Model\OrderContract;
use Combee\Ordering\Contract\Model\OrderItemContract;
use Doctrine\Common\Collections\Collection;

class Order implements OrderContract
{
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
        OrderSealedException::throwIfTrue($this->isSealed());

        $addItemStrategy->addItem($this->items, $item);
    }

    public function isSealed(): bool
    {
        return $this->state !== 'cart';
    }
}
