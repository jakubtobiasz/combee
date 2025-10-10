<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\DataObject;

use Combee\Core\Shared\DataObject\Price;

interface ProductData
{
    public string $sku { get; }

    public Price $price { get; }
}
