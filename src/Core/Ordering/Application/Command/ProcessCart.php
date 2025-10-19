<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Application\Command;

use Recode\Ecommerce\Core\Ordering\Contract\Command\ProcessOrderContract;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

readonly class ProcessCart implements ProcessOrderContract
{
    public function __construct(
        public OrderIdentifier $cartIdentifier,
    ) {
    }
}
