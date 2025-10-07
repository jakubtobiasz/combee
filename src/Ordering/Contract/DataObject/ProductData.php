<?php declare(strict_types=1);

namespace Combee\Ordering\Contract\DataObject;

use Money\Money;

interface ProductData
{
    public string $sku { get; }

    public Money $price { get; }
}
