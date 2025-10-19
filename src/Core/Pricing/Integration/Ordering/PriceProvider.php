<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Pricing\Integration\Ordering;

use Recode\Ecommerce\Core\Ordering\Contract\Provider\PriceProviderContract;
use Recode\Ecommerce\Core\Pricing\Contract\CalculatorContract;
use Recode\Ecommerce\Core\Shared\Contract\Priceable;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

final readonly class PriceProvider implements PriceProviderContract
{
    public function __construct(
        private CalculatorContract $calculator,
    ) {
    }

    /** @inheritDoc */
    public function provideFor(Priceable $priceable, array $context = []): Price
    {
        return $this->calculator->calculate($priceable, $context);
    }
}
