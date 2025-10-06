<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Command;

use Combee\Core\Ordering\Contract\Command\AddProductToCartContract;
use Ramsey\Uuid\UuidInterface;

readonly class AddProductToCart implements AddProductToCartContract
{
    public function __construct(
        public UuidInterface $cartUuid,
        public string $sku,
        /** @var positive-int */
        public int $quantity,
    ) {
    }
}
