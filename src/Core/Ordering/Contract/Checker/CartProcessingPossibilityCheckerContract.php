<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Checker;

use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

interface CartProcessingPossibilityCheckerContract
{
    public function canBeProcessed(OrderIdentifier|OrderContract $order): bool;
}
