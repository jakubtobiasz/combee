<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Recode\Ecommerce\Core\Ordering\Contract\DataObject\ProductData;
use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

class ProductDataMother
{
    public static function some(string $sku = 'OMG', ?Price $price = null): ProductData
    {
        $price = $price ?? Price::new(150, Currency::new('PLN'));

        return new class ($sku, $price) implements ProductData {
            public function __construct(
                public string $sku,
                public Price $price,
            ) {
            }
        };
    }
}
