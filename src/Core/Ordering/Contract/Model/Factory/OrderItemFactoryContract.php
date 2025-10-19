<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Model\Factory;

use Recode\Ecommerce\Core\Ordering\Contract\DataObject\ProductData;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

interface OrderItemFactoryContract
{
    /**
     * @param positive-int $quantity
     */
    public function createFromProductData(ProductData $productData, Price $unitPrice, int $quantity): OrderItemContract;
}
