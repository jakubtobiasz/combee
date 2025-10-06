<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Model;

use Combee\Core\Ordering\Contract\Model\OrderContract;
use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Ramsey\Uuid\UuidInterface;

class Order implements OrderContract
{
    /** @var array<OrderItemContract> */
    private array $items = [];

    public function __construct(
        public readonly UuidInterface $uuid,
    ) {
    }

    public function addItem(OrderItemContract $item): void
    {
        $this->items[] = $item;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
