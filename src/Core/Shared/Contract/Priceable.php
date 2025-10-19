<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Shared\Contract;

use Recode\Ecommerce\Core\Shared\DataObject\Price;

interface Priceable
{
    public Price $price { get; set; }
}
