<?php declare(strict_types=1);

namespace Combee\Ordering\Application\Command\Handler\Exception;

use Combee\Core\Model\Identifier\OrderIdentifier;

class CartNotFoundException extends \InvalidArgumentException
{
    /**
     * @phpstan-assert !null $value
     */
    public static function throwIfNull(mixed $value, OrderIdentifier $cartUuid): void
    {
        if ($value === null) {
            throw new self(
                sprintf('Cart with UUID "%s" not found.', $cartUuid->toString()),
            );
        }
    }
}
