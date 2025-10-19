<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Shared\Contract;

use Recode\Ecommerce\Core\Shared\DataObject\Price;

interface PriceAdjustmentContract
{
    public Price $amount { get; }

    public string $type { get; }

    public string $description { get; }

    public bool $isNeutral { get; }
}
