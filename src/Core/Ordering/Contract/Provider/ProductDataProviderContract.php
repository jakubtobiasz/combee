<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Provider;

use Recode\Ecommerce\Core\Ordering\Contract\DataObject\ProductData;

interface ProductDataProviderContract
{
    public function getProductData(string $sku): ?ProductData;
}
