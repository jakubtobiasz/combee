<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Application\Processor;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Recode\Ecommerce\Core\Ordering\Application\Processor\RefreshUnitItemPricesCartProcessor;
use Recode\Ecommerce\Core\Ordering\Contract\Exception\ProductDataCannotBeProvidedException;
use Recode\Ecommerce\Core\Ordering\Contract\Processor\CartProcessorContract;
use Recode\Ecommerce\Core\Ordering\Contract\Provider\PriceProviderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Provider\ProductDataProviderContract;
use Recode\Ecommerce\Core\Shared\Collection\ArrayCollection;
use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Tests\Helper\MotherObject\OrderItemMother;
use Tests\Helper\MotherObject\OrderMother;
use Tests\Helper\MotherObject\ProductDataMother;

final class RefreshUnitItemPricesCartProcessorTest extends TestCase
{
    private MockObject&PriceProviderContract $priceProviderContract;

    private MockObject&ProductDataProviderContract $productDataProviderContract;

    protected function setUp(): void
    {
        $this->priceProviderContract = $this->createMock(PriceProviderContract::class);
        $this->productDataProviderContract = $this->createMock(ProductDataProviderContract::class);
    }

    #[Test]
    public function it_refreshes_unit_item_prices(): void
    {
        $cartItem = OrderItemMother::some(productSku: 'T-SHIRT1', unitPrice: new Price(2000, Currency::new('PLN')));

        $cart = OrderMother::some();
        $cart->addItem($cartItem);

        $this->productDataProviderContract
            ->method('getProductData')
            ->with('T-SHIRT1')
            ->willReturn($product = ProductDataMother::some('T-SHIRT1', new Price(2000, Currency::new('PLN'))))
        ;

        $this->priceProviderContract
            ->method('provideFor')
            ->with($product)
            ->willReturnOnConsecutiveCalls(
                new Price(1000, Currency::new('PLN')),
            )
        ;

        $this->createTestSubject()->process($cart);

        $this->assertTrue(new Price(1000, Currency::new('PLN'))->equals($cartItem->unitPrice));
    }

    #[Test]
    public function it_skips_refreshing_prices_when_context_contains_the_skip_flag_set_to_true(): void
    {
        $cartItem = OrderItemMother::some(productSku: 'T-SHIRT1', unitPrice: new Price(2000, Currency::new('PLN')));

        $cart = OrderMother::some();
        $cart->addItem($cartItem);

        $this->productDataProviderContract
            ->method('getProductData')
            ->with('T-SHIRT1')
            ->willReturn($product = ProductDataMother::some('T-SHIRT1', new Price(2000, Currency::new('PLN'))))
        ;

        $this->priceProviderContract
            ->method('provideFor')
            ->with($product)
            ->willReturnOnConsecutiveCalls(
                new Price(1000, Currency::new('PLN')),
            )
        ;

        $this->createTestSubject()->process($cart, new ArrayCollection([RefreshUnitItemPricesCartProcessor::SKIP_KEY => true]));

        $this->assertTrue(new Price(2000, Currency::new('PLN'))->equals($cartItem->unitPrice));

        $this->createTestSubject()->process($cart, new ArrayCollection([RefreshUnitItemPricesCartProcessor::SKIP_KEY => false]));

        $this->assertTrue(new Price(1000, Currency::new('PLN'))->equals($cartItem->unitPrice));
    }

    #[Test]
    public function it_throws_an_exception_when_product_with_provided_sku_does_not_exist(): void
    {
        $this->expectException(ProductDataCannotBeProvidedException::class);
        $this->expectExceptionMessage('Product data cannot be provided.');

        $cartItem = OrderItemMother::some(productSku: 'T-SHIRT1', unitPrice: new Price(2000, Currency::new('PLN')));

        $cart = OrderMother::some();
        $cart->addItem($cartItem);

        $this->productDataProviderContract
            ->method('getProductData')
            ->with('T-SHIRT1')
            ->willReturn(null)
        ;

        $this->createTestSubject()->process($cart);
    }

    private function createTestSubject(): CartProcessorContract
    {
        return new RefreshUnitItemPricesCartProcessor($this->priceProviderContract, $this->productDataProviderContract);
    }
}
