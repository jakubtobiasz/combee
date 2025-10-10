<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Model;

use Combee\Core\Shared\Model\Identifier\OrderItemIdentifier;

interface OrderItemContract
{
    public OrderItemIdentifier $uuid { get; }

    public string $productSku { get; }

    public int $quantity { get; set; }
}
