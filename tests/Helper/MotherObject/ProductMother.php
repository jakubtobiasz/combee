<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Combee\Core\ProductCatalog\Contract\Model\ProductContract;
use Combee\Core\ProductCatalog\Model\Product;
use Combee\Core\Shared\DataObject\Currency;
use Combee\Core\Shared\DataObject\Price;
use Combee\Core\Shared\Model\Identifier\ProductIdentifier;

class ProductMother
{
    public static function some(?ProductIdentifier $uuid = null, string $sku = 'OMG', ?Price $price = null): ProductContract
    {
        return new Product(
            $uuid ?? ProductIdentifier::new(),
            $sku,
            $price ?? Price::new(150, Currency::new('PLN')),
        );
    }
}
