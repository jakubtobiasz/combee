<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Processor;

use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Shared\Collection\ArrayCollection;
use Recode\Ecommerce\Core\Shared\Contract\Collection;

interface CartProcessorContract
{
    /**
     * @param Collection<string, mixed> $context
     */
    public function process(OrderContract $cart, Collection $context = new ArrayCollection()): void;
}
