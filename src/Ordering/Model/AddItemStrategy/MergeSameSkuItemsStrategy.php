<?php declare(strict_types=1);

namespace Combee\Ordering\Model\AddItemStrategy;

use Combee\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Combee\Ordering\Contract\Model\OrderItemContract;
use Doctrine\Common\Collections\Collection;

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
