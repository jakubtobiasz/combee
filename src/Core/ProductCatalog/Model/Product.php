<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\ProductCatalog\Model;

use Recode\Ecommerce\Core\ProductCatalog\Contract\Model\ProductContract;
use Recode\Ecommerce\Core\ProductCatalog\Model\Exception\NegativeOrZeroPriceException;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Model\Identifier\ProductIdentifier;

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
