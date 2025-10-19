<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Provider;

use Recode\Ecommerce\Core\Shared\Contract\Priceable;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

interface PriceProviderContract
{
    /**
     * @param array<string, mixed> $context
     */
    public function provideFor(Priceable $priceable, array $context = []): Price;
}
