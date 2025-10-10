<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Combee\Core\ProductCatalog\Contract\Model\ProductContract;
use Combee\Core\ProductCatalog\Model\Product;
use Combee\Core\Shared\Model\Identifier\ProductIdentifier;
use Money\Money;

class ProductMother
{
    public static function some(?ProductIdentifier $uuid = null, string $sku = 'OMG', ?Money $price = null): ProductContract
    {
        return new Product(
            $uuid ?? ProductIdentifier::new(),
            $sku,
            $price ?? Money::PLN(150),
        );
    }
}
