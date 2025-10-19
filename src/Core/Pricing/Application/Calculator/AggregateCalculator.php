<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Pricing\Application\Calculator;

use Recode\Ecommerce\Core\Pricing\Contract\CalculatorContract;
use Recode\Ecommerce\Core\Pricing\Contract\Exception\NoSupportedCalculatorException;
use Recode\Ecommerce\Core\Shared\Contract\Priceable;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Exception\InvalidArgumentException;

final readonly class AggregateCalculator implements CalculatorContract
{
    /** @var iterable<CalculatorContract> */
    private iterable $calculators;

    /**
     * @param iterable<CalculatorContract|mixed> $calculators
     */
    public function __construct(
        iterable $calculators,
    ) {
        $this->calculators = iterator_to_array($calculators);

        foreach ($this->calculators as $calculator) {
            if (!$calculator instanceof CalculatorContract) {
                throw new InvalidArgumentException(sprintf('Calculator must implement "%s".', CalculatorContract::class));
            }
        }
    }

    /**
     * @throws NoSupportedCalculatorException
     */
    public function calculate(Priceable $priceable, array $context = []): Price
    {
        foreach ($this->calculators as $calculator) {
            if (!$calculator->supports($priceable, $context)) {
                continue;
            }

            return $calculator->calculate($priceable, $context);
        }

        NoSupportedCalculatorException::throw();
    }

    public function supports(Priceable $priceable, array $context = []): bool
    {
        return true;
    }
}
