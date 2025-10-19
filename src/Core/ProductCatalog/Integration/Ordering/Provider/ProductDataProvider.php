<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\ProductCatalog\Integration\Ordering\Provider;

use Recode\Ecommerce\Core\Ordering\Contract\DataObject\ProductData;
use Recode\Ecommerce\Core\Ordering\Contract\Provider\ProductDataProviderContract;
use Recode\Ecommerce\Core\ProductCatalog\Contract\Storage\ProductsStorageContract;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

/**
 * @final
 */
class ProductDataProvider implements ProductDataProviderContract
{
    public function __construct(
        private readonly ProductsStorageContract $productsStorage,
    ) {
    }

    public function getProductData(string $sku): ?ProductData
    {
        $product = $this->productsStorage->findBySku($sku);

        if ($product === null) {
            return null;
        }

        return new readonly class ($product->sku, $product->price) implements ProductData {
            public function __construct(
                public string $sku,
                public Price $price,
            ) {
            }
        };
    }
}
