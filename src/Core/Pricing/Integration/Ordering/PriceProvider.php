<?php declare(strict_types=1);

namespace Combee\Core\Pricing\Integration\Ordering;

use Combee\Core\Ordering\Contract\Provider\PriceProviderContract;
use Combee\Core\Pricing\Contract\CalculatorContract;
use Combee\Core\Shared\Contract\Priceable;
use Combee\Core\Shared\DataObject\Price;

final readonly class PriceProvider implements PriceProviderContract
{
    public function __construct(
        private CalculatorContract $calculator,
    ) {
    }

    /** @inheritDoc */
    public function providePriceFor(Priceable $priceable, array $context = []): Price
    {
        return $this->calculator->calculate($priceable, $context);
    }
}
