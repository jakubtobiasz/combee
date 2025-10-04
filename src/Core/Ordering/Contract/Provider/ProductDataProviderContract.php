<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Provider;

use Combee\Core\Ordering\Contract\DataObject\ProductData;

interface ProductDataProviderContract
{
    public function getProductData(string $sku): ProductData;
}