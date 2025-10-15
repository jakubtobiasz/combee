<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Combee\Core\Ordering\Model\OrderItem;
use Combee\Core\Shared\DataObject\Currency;
use Combee\Core\Shared\DataObject\Price;
use Combee\Core\Shared\Model\Identifier\OrderItemIdentifier;

class OrderItemMother
{
    public static function some(
        ?OrderItemIdentifier $uuid = null,
        string $productSku = 'OMG',
        int $quantity = 1,
        ?Price $unitPrice = null,
    ): OrderItemContract {
        return new OrderItem(
            $uuid ?? OrderItemIdentifier::new(),
            $productSku,
            $unitPrice ?? Price::new(150, Currency::new('PLN')),
            $quantity,
        );
    }
}
