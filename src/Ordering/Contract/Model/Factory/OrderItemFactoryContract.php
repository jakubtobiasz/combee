<?php declare(strict_types=1);

namespace Combee\Ordering\Contract\Model\Factory;

use Combee\Ordering\Contract\DataObject\ProductData;
use Combee\Ordering\Contract\Model\OrderItemContract;

interface OrderItemFactoryContract
{
    /**
     * @param positive-int $quantity
     */
    public function createFromProductData(ProductData $productData, int $quantity): OrderItemContract;
}
