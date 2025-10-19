<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Recode\Ecommerce\Core\ProductCatalog\Contract\Model\ProductContract;
use Recode\Ecommerce\Core\ProductCatalog\Model\Product;
use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Model\Identifier\ProductIdentifier;

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
