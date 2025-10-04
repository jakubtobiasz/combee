<?php declare(strict_types=1);

namespace Combee\Core\ProductCatalog\Model;

use Combee\Core\ProductCatalog\Model\Order\Contract\ProductContract;

class Product implements ProductContract
{
    public function __construct(
        public readonly string $sku,
    ) {
    }
}
