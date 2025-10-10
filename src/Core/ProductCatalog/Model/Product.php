<?php declare(strict_types=1);

namespace Combee\Core\ProductCatalog\Model;

use Combee\Core\ProductCatalog\Contract\Model\ProductContract;
use Combee\Core\ProductCatalog\Model\Exception\NegativeOrZeroPriceException;
use Combee\Core\Shared\DataObject\Price;
use Combee\Core\Shared\Model\Identifier\ProductIdentifier;

class Product implements ProductContract
{
    public function __construct(
        public readonly ProductIdentifier $uuid,
        public readonly string $sku,
        public Price $price {
            get => $this->price;
            set {
                NegativeOrZeroPriceException::throwIfNotPositive($value);

                $this->price = $value;
            }
        }
    ) {
    }
}
