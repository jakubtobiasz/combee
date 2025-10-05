<?php declare(strict_types=1);

namespace Combee\Core\ProductCatalog\Model;

use Combee\Core\ProductCatalog\Model\Order\Contract\ProductContract;
use Ramsey\Uuid\UuidInterface;

class Product implements ProductContract
{
    public function __construct(
        public readonly UuidInterface $uuid,
        public readonly string $sku,
    ) {
    }
}
