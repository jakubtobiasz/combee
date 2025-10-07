<?php declare(strict_types=1);

namespace Combee\ProductCatalog\Model\Exception;

use Money\Money;

class NegativeOrZeroPriceException extends \LogicException
{
    public static function throwIfNotPositive(Money $value): void
    {
        if (!$value->isPositive()) {
            throw new self('Price must be greater than zero.');
        }
    }
}
