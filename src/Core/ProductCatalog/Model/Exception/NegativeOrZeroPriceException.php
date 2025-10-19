<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\ProductCatalog\Model\Exception;

use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Exception\LogicException;

class NegativeOrZeroPriceException extends LogicException
{
    public static function throwIfNotPositive(Price $value): void
    {
        if (!$value->isPositive) {
            throw new self('Price must be greater than zero.');
        }
    }
}
