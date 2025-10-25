<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Model;

use Recode\Ecommerce\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Recode\Ecommerce\Core\Ordering\Model\AddItemStrategy\MergeSameSkuItemsStrategy;
use Recode\Ecommerce\Core\Shared\Contract\Collection;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

interface OrderContract
{
    public OrderIdentifier $uuid { get; }

    /** @var Collection<array-key, OrderItemContract> */
    public Collection $items { get; }

    public string $state { get; }

    public bool $isSealed { get; }

    public function addItem(OrderItemContract $item, AddItemStrategyContract $addItemStrategy = new MergeSameSkuItemsStrategy()): void;
}
