<?php declare(strict_types=1);

namespace Combee\Core\Shared\Contract;

use Combee\Core\Shared\DataObject\Price;

interface Priceable
{
    public Price $price { get; set; }
}
