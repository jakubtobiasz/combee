<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Model\Exception;

class OrderSealedException extends \LogicException
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
