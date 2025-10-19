<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Model\Factory;

use Recode\Ecommerce\Core\Ordering\Contract\DataObject\ProductData;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;

interface OrderItemFactoryContract
{
    /**
     * @param positive-int $quantity
     */
    public function createFromProductData(ProductData $productData, int $quantity): OrderItemContract;
}
