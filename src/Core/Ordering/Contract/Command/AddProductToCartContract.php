<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Command;

use Recode\Ecommerce\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

interface AddProductToCartContract
{
    public OrderIdentifier $cartUuid { get; }

    public string $sku { get; }

    /** @var positive-int */
    public int $quantity { get; }

    /** @var class-string<AddItemStrategyContract> */
    public string $strategy { get; }
}
