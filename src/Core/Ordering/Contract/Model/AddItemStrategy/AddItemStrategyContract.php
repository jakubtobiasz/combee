<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Model\AddItemStrategy;

use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Doctrine\Common\Collections\Collection;

interface AddItemStrategyContract
{
    /**
     * @param Collection<array-key, OrderItemContract> $items
     */
    public function addItem(Collection $items, OrderItemContract $newItem): void;
}
