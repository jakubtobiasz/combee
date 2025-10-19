<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\DataObject;

use Recode\Ecommerce\Core\Shared\Contract\Priceable;

interface ProductData extends Priceable
{
    public string $sku { get; }
}
