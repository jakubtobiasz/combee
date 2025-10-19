<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Model\AddItemStrategy;

use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Shared\Contract\Collection;

interface AddItemStrategyContract
{
    /**
     * @param Collection<array-key, OrderItemContract> $items
     */
    public function addItem(Collection $items, OrderItemContract $newItem): void;
}
