<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Model;

use Combee\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Combee\Core\Shared\Model\Identifier\OrderIdentifier;
use Doctrine\Common\Collections\Collection;

interface OrderContract
{
    public OrderIdentifier $uuid { get; }

    /** @var Collection<array-key, OrderItemContract> */
    public Collection $items { get; }

    public string $state { get; }

    public bool $isSealed { get; }

    public function addItem(OrderItemContract $item, AddItemStrategyContract $addItemStrategy): void;
}
