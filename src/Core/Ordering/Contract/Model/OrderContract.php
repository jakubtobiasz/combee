<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Model;

use Combee\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

interface OrderContract
{
    public UuidInterface $uuid { get; }

    /** @var Collection<array-key, OrderItemContract> */
    public Collection $items { get; }

    public string $state { get; }

    public function addItem(OrderItemContract $item, AddItemStrategyContract $addItemStrategy): void;
}
