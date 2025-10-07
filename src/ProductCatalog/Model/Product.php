<?php declare(strict_types=1);

namespace Combee\ProductCatalog\Model;

use Combee\ProductCatalog\Contract\Model\ProductContract;
use Combee\ProductCatalog\Model\Exception\NegativeOrZeroPriceException;
use Money\Money;
use Ramsey\Uuid\UuidInterface;

class Product implements ProductContract
{
    public function __construct(
        public readonly UuidInterface $uuid,
        public readonly string $sku,
        public Money $price {
            get => $this->price;
            set {
                NegativeOrZeroPriceException::throwIfNotPositive($value);

                $this->price = $value;
            }
        }
    ) {
    }
}
