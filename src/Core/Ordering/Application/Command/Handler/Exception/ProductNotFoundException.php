<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Application\Command\Handler\Exception;

use Combee\Core\Shared\Exception\InvalidArgumentException;

class ProductNotFoundException extends InvalidArgumentException
{
    /**
     * @phpstan-assert !null $value
     */
    public static function throwIfNull(mixed $value, string $sku): void
    {
        if ($value === null) {
            throw new self(
                sprintf('Product with SKU "%s" not found.', $sku)
            );
        }
    }
}
