<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Application\Command\Handler;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Recode\Ecommerce\Core\Ordering\Application\Command\AddProductToCart;
use Recode\Ecommerce\Core\Ordering\Application\Command\Handler\AddProductToCartHandler;
use Recode\Ecommerce\Core\Ordering\Application\Command\Handler\Exception\ProductNotFoundException;
use Recode\Ecommerce\Core\Ordering\Contract\Command\AddProductToCartContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\Factory\OrderItemFactoryContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Ordering\Contract\Provider\PriceProviderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Provider\ProductDataProviderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Storage\CartStorageContract;
use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;
use Tests\Helper\MotherObject\ProductDataMother;

final class AddProductToCartHandlerTest extends TestCase
{
    private MockObject&ProductDataProviderContract $productDataProvider;

    private MockObject&PriceProviderContract $priceProvider;

    private MockObject&CartStorageContract $cartStorage;

    private MockObject&OrderItemFactoryContract $orderItemFactory;

    protected function setUp(): void
    {
        $this->productDataProvider = $this->createMock(ProductDataProviderContract::class);
        $this->priceProvider = $this->createMock(PriceProviderContract::class);
        $this->cartStorage = $this->createMock(CartStorageContract::class);
        $this->orderItemFactory = $this->createMock(OrderItemFactoryContract::class);
    }

    #[Test]
    public function it_adds_product_to_cart(): void
    {
        $command = new AddProductToCart($cartUuid = OrderIdentifier::new(), 'OMG', 2);

        $cart = $this->createMock(OrderContract::class);

        $this->cartStorage->method('findByIdentifier')->with($cartUuid)->willReturn($cart);

        $productData = ProductDataMother::some('OMG', new Price(2, new Currency('EUR')));

        $this->productDataProvider->method('getProductData')->willReturn($productData);
        $this->priceProvider->method('provideFor')->with($productData)->willReturn($providedPrice = new Price(2, new Currency('EUR')));

        $cartItem = $this->createMock(OrderItemContract::class);

        $this->orderItemFactory->method('createFromProductData')->with($productData, $providedPrice, 2)->willReturn($cartItem);

        $this->cartStorage->expects($this->once())->method('store')->with($cart);

        $cart->expects($this->once())->method('addItem')->with($cartItem, $this->isInstanceOf(AddItemStrategyContract::class));

        $this->dispatch($command);
    }

    #[Test]
    public function it_throws_exception_if_cart_not_found(): void
    {
        $command = new AddProductToCart($cartUuid = OrderIdentifier::new(), 'OMG', 2);

        $this->cartStorage->method('findByIdentifier')->with($cartUuid)->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Cart with UUID "%s" not found.', $cartUuid->toString()));

        $this->dispatch($command);
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

        $this->dispatch($command);
    }

    private function dispatch(AddProductToCartContract $command): void
    {
        $handler = new AddProductToCartHandler(
            $this->productDataProvider,
            $this->priceProvider,
            $this->cartStorage,
            $this->orderItemFactory,
        );

        $handler->__invoke($command);
    }
}
