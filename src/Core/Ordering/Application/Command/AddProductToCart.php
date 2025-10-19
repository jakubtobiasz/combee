<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Application\Command;

use Recode\Ecommerce\Core\Ordering\Contract\Command\AddProductToCartContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Recode\Ecommerce\Core\Ordering\Model\AddItemStrategy\MergeSameSkuItemsStrategy;
use Recode\Ecommerce\Core\Shared\Exception\InvalidArgumentException;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

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
