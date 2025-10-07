<?php declare(strict_types=1);

namespace Combee\ProductCatalog\Contract\Model;

use Combee\Core\Contract\Priceable;

interface ProductContract extends Priceable
{
    public string $sku { get; }
}
