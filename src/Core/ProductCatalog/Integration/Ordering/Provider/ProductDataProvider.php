<?php declare(strict_types=1);

namespace Combee\Core\ProductCatalog\Integration\Ordering\Provider;

use Combee\Core\Ordering\Contract\DataObject\ProductData;
use Combee\Core\Ordering\Contract\Provider\ProductDataProviderContract;

/**
 * @final
 */
class ProductDataProvider implements ProductDataProviderContract
{
    public function getProductData(string $sku): ProductData
    {
        return new class () implements ProductData {
            public string $sku = 'sku';

            public string $name = 'name';
        };
    }
}
