<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Combee\Ordering\Model\OrderItem;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class OrderItemMother
{
    public static function some(?UuidInterface $uuid = null, string $productSku = 'OMG', int $quantity = 1): OrderItem
    {
        return new OrderItem($uuid ?? Uuid::uuid4(), $productSku, $quantity);
    }
}
