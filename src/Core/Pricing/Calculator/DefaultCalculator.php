<?php declare(strict_types=1);

namespace Combee\Core\Pricing\Calculator;

use Combee\Core\Pricing\Contract\CalculatorContract;
use Combee\Core\Shared\Contract\Priceable;
use Combee\Core\Shared\DataObject\Price;

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
