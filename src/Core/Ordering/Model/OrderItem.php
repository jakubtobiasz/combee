<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Model;

use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Combee\Core\Ordering\Model\Exception\NegativeOrZeroQuantityException;
use Combee\Core\Shared\Model\Identifier\OrderItemIdentifier;

class OrderItem implements OrderItemContract
{
    public function __construct(
        public readonly OrderItemIdentifier $uuid,
        public readonly string $productSku,
        public int $quantity {
            get {
                return $this->quantity;
            }
            set {
                NegativeOrZeroQuantityException::throwIfNegativeOrZero($value);

                $this->quantity = $value;
            }
        },
    ) {
    }
}
