<?php declare(strict_types=1);

namespace Combee\Ordering\Contract\Model;

use Combee\Core\Model\Identifier\OrderIdentifier;
use Combee\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Doctrine\Common\Collections\Collection;

interface OrderContract
{
    public OrderIdentifier $uuid { get; }

    /** @var Collection<array-key, OrderItemContract> */
    public Collection $items { get; }

    public string $state { get; }

    public function addItem(OrderItemContract $item, AddItemStrategyContract $addItemStrategy): void;
}
