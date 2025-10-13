<?php declare(strict_types=1);

namespace Combee\Core\Pricing\Calculator;

use Combee\Core\Pricing\Contract\CalculatorContract;
use Combee\Core\Pricing\Contract\Exception\NoSupportedCalculatorException;
use Combee\Core\Shared\Contract\Priceable;
use Combee\Core\Shared\DataObject\Price;
use Combee\Core\Shared\Exception\InvalidArgumentException;

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
        $this->calculators = $calculators instanceof \Traversable ? iterator_to_array($calculators) : $calculators;

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
