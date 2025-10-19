<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Application\Command\Handler;

use Recode\Ecommerce\Core\Ordering\Application\Command\ProcessCart;
use Recode\Ecommerce\Core\Ordering\Contract\Checker\CartProcessingPossibilityCheckerContract;
use Recode\Ecommerce\Core\Ordering\Contract\Processor\CartProcessorContract;
use Recode\Ecommerce\Core\Ordering\Contract\Storage\CartStorageContract;

final readonly class ProcessCartHandler
{
    public function __construct(
        private CartStorageContract $cartStorage,
        private CartProcessingPossibilityCheckerContract $cartProcessingPossibilityChecker,
        private CartProcessorContract $cartProcessor,
    ) {
    }

    public function __invoke(ProcessCart $command): void
    {
        $cart = $this->cartStorage->findByIdentifier($command->cartIdentifier);

        if ($cart === null || !$this->cartProcessingPossibilityChecker->canBeProcessed($cart)) {
            return;
        }

        $this->cartProcessor->process($cart);
    }
}
