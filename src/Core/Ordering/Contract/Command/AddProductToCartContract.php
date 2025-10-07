<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Command;

use Combee\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Ramsey\Uuid\UuidInterface;

interface AddProductToCartContract
{
    public UuidInterface $cartUuid { get; }

    public string $sku { get; }

    /** @var positive-int */
    public int $quantity { get; }

    /** @var class-string<AddItemStrategyContract> */
    public string $strategy { get; }
}
