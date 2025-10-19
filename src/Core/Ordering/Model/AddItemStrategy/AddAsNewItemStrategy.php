<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Model\AddItemStrategy;

use Recode\Ecommerce\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Shared\Contract\Collection;

final readonly class AddAsNewItemStrategy implements AddItemStrategyContract
{
    public function addItem(Collection $items, OrderItemContract $newItem): void
    {
        $items->add($newItem);
    }
}
