<?php declare(strict_types=1);

namespace Combee\Core\Pricing\Contract;

use Combee\Core\Shared\Contract\Priceable;
use Combee\Core\Shared\DataObject\Price;

interface CalculatorContract
{
    /**
     * @param array<string, mixed> $context
     */
    public function calculate(Priceable $priceable, array $context = []): Price;

    /**
     * @param array<string, mixed> $context
     */
    public function supports(Priceable $priceable, array $context = []): bool;
}
