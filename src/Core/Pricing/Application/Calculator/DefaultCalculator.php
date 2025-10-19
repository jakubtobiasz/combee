<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Pricing\Application\Calculator;

use Recode\Ecommerce\Core\Pricing\Contract\CalculatorContract;
use Recode\Ecommerce\Core\Shared\Contract\Priceable;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

final readonly class DefaultCalculator implements CalculatorContract
{
    public function calculate(Priceable $priceable, array $context = []): Price
    {
        return $priceable->price;
    }

    public function supports(Priceable $priceable, array $context = []): bool
    {
        return true;
    }
}
