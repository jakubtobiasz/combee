<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Application\Command\Handler;

use Recode\Ecommerce\Core\Ordering\Application\Command\AddProductToCart;
use Recode\Ecommerce\Core\Ordering\Application\Command\Handler\AddProductToCartHandler;
use Recode\Ecommerce\Core\Ordering\Application\Command\Handler\Exception\ProductNotFoundException;
use Recode\Ecommerce\Core\Ordering\Contract\DataObject\ProductData;
use Recode\Ecommerce\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\Factory\OrderItemFactoryContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Ordering\Contract\Provider\ProductDataProviderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Storage\CartStorageContract;
use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

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
        $command = new AddProductToCart($cartUuid = OrderIdentifier::new(), 'OMG', 2);

        $cart = $this->createMock(OrderContract::class);

        $this->cartStorage->method('findByIdentifier')->with($cartUuid)->willReturn($cart);

        $productData = new class () implements ProductData {
            public string $sku { get => 'OMG'; }

            public Price $price { get => Price::new(100, Currency::new('PLN')); }
        };

        $this->productDataProvider->method('getProductData')->willReturn($productData);

        $cartItem = $this->createMock(OrderItemContract::class);

        $this->orderItemFactory->method('createFromProductData')->with($productData, 2)->willReturn($cartItem);

        $this->cartStorage->expects($this->once())->method('store')->with($cart);

        $cart->expects($this->once())->method('addItem')->with($cartItem, $this->isInstanceOf(AddItemStrategyContract::class));

        new AddProductToCartHandler($this->productDataProvider, $this->cartStorage, $this->orderItemFactory)
            ->__invoke($command)
        ;
    }

    #[Test]
    public function it_throws_exception_if_cart_not_found(): void
    {
        $command = new AddProductToCart($cartUuid = OrderIdentifier::new(), 'OMG', 2);

        $this->cartStorage->method('findByIdentifier')->with($cartUuid)->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Cart with UUID "%s" not found.', $cartUuid->toString()));

        new AddProductToCartHandler($this->productDataProvider, $this->cartStorage, $this->orderItemFactory)
            ->__invoke($command)
        ;
    }

    #[Test]
    public function it_throws_exception_if_product_not_found(): void
    {
        $command = new AddProductToCart($cartUuid = OrderIdentifier::new(), 'OMG', 2);

        $cart = $this->createMock(OrderContract::class);

        $this->cartStorage->method('findByIdentifier')->with($cartUuid)->willReturn($cart);

        $this->productDataProvider->method('getProductData')->willReturn(null);

        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('Product with SKU "OMG" not found.');

        new AddProductToCartHandler($this->productDataProvider, $this->cartStorage, $this->orderItemFactory)
            ->__invoke($command)
        ;
    }
}
