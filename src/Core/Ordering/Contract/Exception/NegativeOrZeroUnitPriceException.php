<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Exception;

use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Exception\LogicException;

class NegativeOrZeroUnitPriceException extends LogicException
{
    public static function throwIfNotPositive(Price $value): void
    {
        if (!$value->isPositive) {
            throw new self('Unit prie must be greater than zero.');
        }
    }
}
