<?php declare(strict_types=1);

namespace Combee\Core\ProductCatalog\Model\Order\Contract;

interface ProductContract
{
    public string $sku { get; }
}
