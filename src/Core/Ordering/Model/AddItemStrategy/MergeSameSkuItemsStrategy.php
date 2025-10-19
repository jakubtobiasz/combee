<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Model\AddItemStrategy;

use Recode\Ecommerce\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Shared\Contract\Collection;

final readonly class MergeSameSkuItemsStrategy implements AddItemStrategyContract
{
    public function addItem(Collection $items, OrderItemContract $newItem): void
    {
        $existingItem = $items->findFirst(
            fn (int $_, OrderItemContract $item): bool => $item->productSku === $newItem->productSku,
        );

        if ($existingItem !== null) {
            $existingItem->quantity += $newItem->quantity;

            return;
        }

        $items->add($newItem);
    }
}
