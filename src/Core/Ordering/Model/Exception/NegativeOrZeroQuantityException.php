<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Model\Exception;

use Combee\Core\Shared\Exception\LogicException;

class NegativeOrZeroQuantityException extends LogicException
{
    /**
     * @phpstan-assert positive-int $quantity
     */
    public static function throwIfNegativeOrZero(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new self('Quantity must be greater than zero.');
        }
    }
}
