<?php declare(strict_types=1);

namespace Combee\Core\ProductCatalog\Integration\Ordering\Provider;

use Combee\Core\Ordering\Contract\DataObject\ProductData;
use Combee\Core\Ordering\Contract\Provider\ProductDataProviderContract;
use Money\Money;

/**
 * @final
 */
class ProductDataProvider implements ProductDataProviderContract
{
    public function getProductData(string $sku): ?ProductData
    {
        if ($sku === 'WOW') {
            return null;
        }

        return new class () implements ProductData {
            public string $sku = 'sku';

            public Money $price {
                get => Money::PLN(100);
            }
        };
    }
}
