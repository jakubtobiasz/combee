<?php declare(strict_types=1);

namespace Combee\Ordering\Model;

use Combee\Core\Model\Identifier\OrderItemIdentifier;
use Combee\Ordering\Contract\Model\OrderItemContract;
use Combee\Ordering\Model\Exception\NegativeOrZeroQuantityException;

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
