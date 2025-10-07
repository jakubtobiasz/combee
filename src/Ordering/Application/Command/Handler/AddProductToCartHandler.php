<?php declare(strict_types=1);

namespace Combee\Ordering\Application\Command\Handler;

use Combee\Ordering\Application\Command\Handler\Exception\CartNotFoundException;
use Combee\Ordering\Application\Command\Handler\Exception\ProductNotFoundException;
use Combee\Ordering\Contract\Command\AddProductToCartContract;
use Combee\Ordering\Contract\Model\Factory\OrderItemFactoryContract;
use Combee\Ordering\Contract\Provider\ProductDataProviderContract;
use Combee\Ordering\Contract\Storage\CartStorageContract;

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
        $cart = $this->cartStorage->get($command->cartUuid);
        CartNotFoundException::throwIfNull($cart, $command->cartUuid);

        $product = $this->productDataProvider->getProductData($command->sku);
        ProductNotFoundException::throwIfNull($product, $command->sku);

        $orderItem = $this->orderItemFactory->createFromProductData($product, $command->quantity);

        $cart->addItem($orderItem, new $command->strategy());

        $this->cartStorage->save($cart);
    }
}
