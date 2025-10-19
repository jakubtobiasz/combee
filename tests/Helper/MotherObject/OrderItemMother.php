<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Ordering\Model\OrderItem;
use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderItemIdentifier;

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
