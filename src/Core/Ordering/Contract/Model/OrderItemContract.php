<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Model;

use Ramsey\Uuid\UuidInterface;

interface OrderItemContract
{
    public UuidInterface $uuid { get; }

    public string $productSku { get; }

    public int $quantity { get; set; }
}
