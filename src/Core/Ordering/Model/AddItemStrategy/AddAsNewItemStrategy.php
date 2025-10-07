<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Model\AddItemStrategy;

use Combee\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Doctrine\Common\Collections\Collection;

final class AddAsNewItemStrategy implements AddItemStrategyContract
{
    public function addItem(Collection $items, OrderItemContract $item): void
    {
        $items->add($item);
    }
}
