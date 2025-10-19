<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Model\Factory;

use Combee\Core\Ordering\Contract\DataObject\ProductData;
use Combee\Core\Ordering\Contract\Model\Factory\OrderItemFactoryContract;
use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Combee\Core\Ordering\Model\OrderItem;
use Combee\Core\Shared\Model\Identifier\OrderItemIdentifier;

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
