<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Model\Factory;

use Recode\Ecommerce\Core\Ordering\Contract\DataObject\ProductData;
use Recode\Ecommerce\Core\Ordering\Contract\Model\Factory\OrderItemFactoryContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Ordering\Model\OrderItem;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderItemIdentifier;

final class OrderItemFactory implements OrderItemFactoryContract
{
    public function createFromProductData(ProductData $productData, int $quantity): OrderItemContract
    {
        return new OrderItem(
            OrderItemIdentifier::new(),
            $productData->sku,
            $productData->price,
            $quantity,
        );
    }
}
