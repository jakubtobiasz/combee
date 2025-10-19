<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Application\Checker;

use Recode\Ecommerce\Core\Ordering\Contract\Checker\CartProcessingPossibilityCheckerContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Storage\CartStorageContract;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

final readonly class CartProcessingPossibilityChecker implements CartProcessingPossibilityCheckerContract
{
    public function __construct(
        private CartStorageContract $cartStorage,
    ) {
    }

    public function canBeProcessed(OrderIdentifier|OrderContract $order): bool
    {
        if ($order instanceof OrderIdentifier) {
            $order = $this->cartStorage->findByIdentifier($order);
        }

        if ($order === null) {
            return false;
        }

        return $order->isSealed === false;
    }
}
