<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Application\Command\Handler\Exception;

use Recode\Ecommerce\Core\Shared\Exception\InvalidArgumentException;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

class CartNotFoundException extends InvalidArgumentException
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
