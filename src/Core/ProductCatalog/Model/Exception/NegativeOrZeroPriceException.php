<?php declare(strict_types=1);

namespace Combee\Core\ProductCatalog\Model\Exception;

use Combee\Core\Shared\DataObject\Price;
use Combee\Core\Shared\Exception\LogicException;

class NegativeOrZeroPriceException extends LogicException
{
    public static function throwIfNotPositive(Price $value): void
    {
        if (!$value->isPositive) {
            throw new self('Price must be greater than zero.');
        }
    }
}
