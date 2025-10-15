<?php declare(strict_types=1);

namespace Combee\Core\Shared\Contract;

use Combee\Core\Shared\DataObject\Price;

interface PriceAdjustmentContract
{
    public Price $amount { get; }

    public string $type { get; }

    public string $description { get; }

    public bool $isNeutral { get; }
}