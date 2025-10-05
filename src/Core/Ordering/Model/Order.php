<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Model;

use Combee\Core\Ordering\Contract\Model\OrderContract;
use Ramsey\Uuid\UuidInterface;

class Order implements OrderContract
{
    public function __construct(
        public readonly UuidInterface $uuid,
    ) {
    }
}
