<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Pricing\Contract;

use Recode\Ecommerce\Core\Shared\Contract\Priceable;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

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
