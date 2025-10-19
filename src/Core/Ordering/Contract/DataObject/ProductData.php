<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\DataObject;

use Recode\Ecommerce\Core\Shared\DataObject\Price;

interface ProductData
{
    public string $sku { get; }

    public Price $price { get; }
}
