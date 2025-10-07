<?php declare(strict_types=1);

namespace Combee\Ordering\Contract\Provider;

use Combee\Ordering\Contract\DataObject\ProductData;

interface ProductDataProviderContract
{
    public function getProductData(string $sku): ?ProductData;
}
