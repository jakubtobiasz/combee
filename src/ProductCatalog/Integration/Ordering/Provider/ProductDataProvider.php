<?php declare(strict_types=1);

namespace Combee\ProductCatalog\Integration\Ordering\Provider;

use Combee\Ordering\Contract\DataObject\ProductData;
use Combee\Ordering\Contract\Provider\ProductDataProviderContract;

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
        };
    }
}
