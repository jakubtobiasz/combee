<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Provider;

use Combee\Core\Shared\Contract\Priceable;
use Combee\Core\Shared\DataObject\Price;

interface PriceProviderContract
{
    /**
     * @param array<string, mixed> $context
     */
    public function providePriceFor(Priceable $priceable, array $context = []): Price;
}
