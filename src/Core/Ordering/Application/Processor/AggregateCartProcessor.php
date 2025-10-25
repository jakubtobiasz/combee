<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Application\Processor;

use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Processor\CartProcessorContract;
use Recode\Ecommerce\Core\Shared\Collection\ArrayCollection;
use Recode\Ecommerce\Core\Shared\Contract\Collection;
use Recode\Ecommerce\Core\Shared\Exception\InvalidArgumentException;

final readonly class AggregateCartProcessor implements CartProcessorContract
{
    /** @var iterable<CartProcessorContract> */
    private iterable $subprocessors;

    /**
     * @param iterable<CartProcessorContract> $subprocessors
     */
    public function __construct(
        iterable $subprocessors,
    ) {
        $this->subprocessors = iterator_to_array($subprocessors);

        foreach ($this->subprocessors as $subprocessor) {
            if (!$subprocessor instanceof CartProcessorContract) {
                throw new InvalidArgumentException(sprintf('All subprocessors must implement "%s".', CartProcessorContract::class));
            }
        }
    }

    public function process(OrderContract $cart, Collection $context = new ArrayCollection()): void
    {
        foreach ($this->subprocessors as $subprocessor) {
            $subprocessor->process($cart, $context);
        }
    }
}
