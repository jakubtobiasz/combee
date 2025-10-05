<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Model;

use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Ramsey\Uuid\UuidInterface;

class OrderItem implements OrderItemContract
{
    public function __construct(
        public readonly UuidInterface $uuid,
    ) {
    }
}
