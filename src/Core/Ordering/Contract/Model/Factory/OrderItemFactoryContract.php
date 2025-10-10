<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Model\Factory;

use Combee\Core\Ordering\Contract\DataObject\ProductData;
use Combee\Core\Ordering\Contract\Model\OrderItemContract;

interface OrderItemFactoryContract
{
    /**
     * @param positive-int $quantity
     */
    public function createFromProductData(ProductData $productData, int $quantity): OrderItemContract;
}
