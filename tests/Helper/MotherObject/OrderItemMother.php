<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Combee\Core\Model\Identifier\OrderItemIdentifier;
use Combee\Ordering\Contract\Model\OrderItemContract;
use Combee\Ordering\Model\OrderItem;

class OrderItemMother
{
    public static function some(?OrderItemIdentifier $uuid = null, string $productSku = 'OMG', int $quantity = 1): OrderItemContract
    {
        return new OrderItem($uuid ?? OrderItemIdentifier::new(), $productSku, $quantity);
    }
}
