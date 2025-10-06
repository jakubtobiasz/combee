<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Model;

interface OrderContract
{
    public function addItem(OrderItemContract $item): void;

    /**
     * @return array<OrderItemContract>
     */
    public function getItems(): array;
}
