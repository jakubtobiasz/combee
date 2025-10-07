<?php declare(strict_types=1);

namespace Combee\Ordering\Command\Handler\Exception;

use Ramsey\Uuid\UuidInterface;

class CartNotFoundException extends \InvalidArgumentException
{
    /**
     * @phpstan-assert !null $value
     */
    public static function throwIfNull(mixed $value, UuidInterface $cartUuid): void
    {
        if ($value === null) {
            throw new self(
                sprintf('Cart with UUID "%s" not found.', $cartUuid->toString()),
            );
        }
    }
}
