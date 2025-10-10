<?php declare(strict_types=1);

namespace Combee\Core\Shared\Contract;

use Money\Money;

interface Priceable
{
    public Money $price { get; set; }
}
