<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Command;

use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

interface ProcessOrderContract
{
    public OrderIdentifier $cartIdentifier { get; }
}
