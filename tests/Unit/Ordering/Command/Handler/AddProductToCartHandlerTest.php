<?php declare(strict_types=1);

namespace Tests\Unit\Ordering\Command\Handler;

use Combee\Core\Ordering\Command\AddProductToCart;
use Combee\Core\Ordering\Command\Handler\AddProductToCartHandler;
use Combee\Core\Ordering\Command\Handler\Exception\ProductNotFoundException;
use Combee\Core\Ordering\Contract\DataObject\ProductData;
use Combee\Core\Ordering\Contract\Model\Factory\OrderItemFactoryContract;
use Combee\Core\Ordering\Contract\Model\OrderContract;
use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Combee\Core\Ordering\Contract\Provider\ProductDataProviderContract;
use Combee\Core\Ordering\Contract\Storage\CartStorageContract;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class AddProductToCartHandlerTest extends TestCase
{
    private MockObject&ProductDataProviderContract $productDataProvider;

    private MockObject&CartStorageContract $cartStorage;

    private MockObject&OrderItemFactoryContract $orderItemFactory;

    protected function setUp(): void
    {
        $this->productDataProvider = $this->createMock(ProductDataProviderContract::class);
        $this->cartStorage = $this->createMock(CartStorageContract::class);
        $this->orderItemFactory = $this->createMock(OrderItemFactoryContract::class);
    }

    #[Test]
    public function it_adds_product_to_cart(): void
    {
        $command = new AddProductToCart($cartUuid = Uuid::uuid4(), 'OMG', 2);

        $cart = $this->createMock(OrderContract::class);

        $this->cartStorage->method('get')->with($cartUuid)->willReturn($cart);

        $productData = new class implements ProductData {
            public string $sku { get => 'OMG'; }
        };

        $this->productDataProvider->method('getProductData')->willReturn($productData);

        $cartItem = $this->createMock(OrderItemContract::class);

        $this->orderItemFactory->method('createFromProductData')->with($productData, 2)->willReturn($cartItem);

        $cart->expects($this->once())->method('addItem')->with($cartItem);

        new AddProductToCartHandler($this->productDataProvider, $this->cartStorage, $this->orderItemFactory)
            ->__invoke($command)
        ;
    }

    #[Test]
    public function it_throws_exception_if_cart_not_found(): void
    {
        $command = new AddProductToCart($cartUuid = Uuid::uuid4(), 'OMG', 2);

        $this->cartStorage->method('get')->with($cartUuid)->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Cart with UUID "%s" not found.', $cartUuid->toString()));

        new AddProductToCartHandler($this->productDataProvider, $this->cartStorage, $this->orderItemFactory)
            ->__invoke($command)
        ;
    }

    #[Test]
    public function it_throws_exception_if_product_not_found(): void
    {
        $command = new AddProductToCart($cartUuid = Uuid::uuid4(), 'OMG', 2);

        $cart = $this->createMock(OrderContract::class);

        $this->cartStorage->method('get')->with($cartUuid)->willReturn($cart);

        $this->productDataProvider->method('getProductData')->willReturn(null);

        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('Product with SKU "OMG" not found.');

        new AddProductToCartHandler($this->productDataProvider, $this->cartStorage, $this->orderItemFactory)
            ->__invoke($command)
        ;
    }
}