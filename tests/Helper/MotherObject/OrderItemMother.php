<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Combee\Core\Ordering\Model\OrderItem;
use Combee\Core\Shared\Model\Identifier\OrderItemIdentifier;

class OrderItemMother
{
    public static function some(?OrderItemIdentifier $uuid = null, string $productSku = 'OMG', int $quantity = 1): OrderItemContract
    {
        return new OrderItem($uuid ?? OrderItemIdentifier::new(), $productSku, $quantity);
    }
}
