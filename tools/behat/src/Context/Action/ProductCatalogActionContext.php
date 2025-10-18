<?php declare(strict_types=1);

namespace Tools\Behat\Context\Action;

use Behat\Behat\Context\Context;
use Behat\Step\When;
use Combee\Core\Ordering\Application\Command\AddProductToCart;
use Combee\Core\Ordering\Application\Command\Handler\AddProductToCartHandler;
use Combee\Core\Ordering\Contract\Model\OrderContract;
use Combee\Core\ProductCatalog\Contract\Model\ProductContract;

class ProductCatalogActionContext implements Context
{
    public function __construct(
        private readonly AddProductToCartHandler $addProductToCartHandler,
    ) {
    }

    #[When('/^I add a single ("[^"]+" product) to (the cart)$/')]
    public function iAddSingleProductToTheCart(ProductContract $product, OrderContract $cart): void
    {
        $this->addProductToCartHandler->__invoke(
            new AddProductToCart(
                $cart->uuid,
                $product->sku,
                1,
            )
        );
    }

    #[When('/^I add (\d+) items of the ("[^"]+" product) to (the cart)$/')]
    public function iAddProductToTheCart(int $quantity, ProductContract $product, OrderContract $cart): void
    {
        $this->addProductToCartHandler->__invoke(
            new AddProductToCart(
                $cart->uuid,
                $product->sku,
                $quantity,
            )
        );
    }
}