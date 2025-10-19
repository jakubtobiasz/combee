<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Model\Exception;

use Recode\Ecommerce\Core\Shared\Exception\LogicException;

class OrderSealedException extends LogicException
{
    /**
     * @phpstan-assert !true $value
     */
    public static function throwIfTrue(bool $value): void
    {
        if ($value) {
            throw new self('Order is sealed and cannot be modified');
        }
    }
}
