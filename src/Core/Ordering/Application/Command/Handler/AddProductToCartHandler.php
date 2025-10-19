<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Application\Command\Handler;

use Recode\Ecommerce\Core\Ordering\Application\Command\Handler\Exception\CartNotFoundException;
use Recode\Ecommerce\Core\Ordering\Application\Command\Handler\Exception\ProductNotFoundException;
use Recode\Ecommerce\Core\Ordering\Contract\Command\AddProductToCartContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\Factory\OrderItemFactoryContract;
use Recode\Ecommerce\Core\Ordering\Contract\Provider\ProductDataProviderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Storage\CartStorageContract;

readonly class AddProductToCartHandler
{
    public function __construct(
        private ProductDataProviderContract $productDataProvider,
        private CartStorageContract $cartStorage,
        private OrderItemFactoryContract $orderItemFactory,
    ) {
    }

    public function __invoke(AddProductToCartContract $command): void
    {
        $cart = $this->cartStorage->findByIdentifier($command->cartUuid);
        CartNotFoundException::throwIfNull($cart, $command->cartUuid);

        $product = $this->productDataProvider->getProductData($command->sku);
        ProductNotFoundException::throwIfNull($product, $command->sku);

        $orderItem = $this->orderItemFactory->createFromProductData($product, $command->quantity);

        $cart->addItem($orderItem, new $command->strategy());

        $this->cartStorage->store($cart);
    }
}
