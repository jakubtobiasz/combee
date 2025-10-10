<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Application\Command;

use Combee\Core\Ordering\Contract\Command\AddProductToCartContract;
use Combee\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Combee\Core\Ordering\Model\AddItemStrategy\MergeSameSkuItemsStrategy;
use Combee\Core\Shared\Exception\InvalidArgumentException;
use Combee\Core\Shared\Model\Identifier\OrderIdentifier;

readonly class AddProductToCart implements AddProductToCartContract
{
    /**
     * @param class-string<AddItemStrategyContract> $strategy
     */
    public function __construct(
        public OrderIdentifier $cartUuid,
        public string $sku,
        /** @var positive-int */
        public int $quantity,
        public string $strategy = MergeSameSkuItemsStrategy::class,
    ) {
        if (!is_a($this->strategy, AddItemStrategyContract::class, true)) {
            throw new InvalidArgumentException(sprintf(
                'Strategy "%s" must implement "%s".',
                $this->strategy,
                AddItemStrategyContract::class,
            ));
        }
    }
}
