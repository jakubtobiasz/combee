<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Exception;

use Recode\Ecommerce\Core\Shared\Exception\Exception;

class ProductDataCannotBeProvidedException extends Exception
{
    /**
     * @phpstan-assert !null $value
     *
     * @throws ProductDataCannotBeProvidedException
     */
    public static function throwIfNull(mixed $value): void
    {
        if ($value === null) {
            throw new ProductDataCannotBeProvidedException('Product data cannot be provided.');
        }
    }
}
