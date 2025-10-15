<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Model;

use Combee\Core\Ordering\Model\Exception\NegativeOrZeroQuantityException;
use Combee\Core\Shared\DataObject\Currency;
use Combee\Core\Shared\DataObject\Price;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Helper\MotherObject\OrderItemMother;
use Tests\Helper\MotherObject\PriceAdjustmentMother;

final class OrderItemTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $item = OrderItemMother::some();

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    #[DataProvider('provideInvalidQuantity')]
    public function it_prevents_creating_an_item_with_negative_quantity(int $quantity): void
    {
        $this->expectException(NegativeOrZeroQuantityException::class);
        $this->expectExceptionMessage('Quantity must be greater than zero.');

        $item = OrderItemMother::some(quantity: $quantity);
    }

    /**
     * @return iterable<array<int>>
     */
    public static function provideInvalidQuantity(): iterable
    {
        yield 'negative' => [-1];
        yield 'zero' => [0];
    }

    #[Test]
    public function it_returns_price(): void
    {
        $item = OrderItemMother::some(quantity: 2, unitPrice: new Price(1000, Currency::new('PLN')));

        $this->assertTrue(new Price('2000', Currency::new('PLN'))->equals($item->price));

        $item->addPriceAdjustment($adjustment = PriceAdjustmentMother::some(new Price(1500, Currency::new('PLN'))));

        $this->assertTrue(new Price('3500', Currency::new('PLN'))->equals($item->price));

        $item->removePriceAdjustment($adjustment);

        $this->assertTrue(new Price('2000', Currency::new('PLN'))->equals($item->price));
    }

    #[Test]
    public function it_caches_price(): void
    {
        $item = OrderItemMother::some(quantity: 2, unitPrice: new Price(1000, Currency::new('PLN')));

        $firstPrice = $item->price;
        $secondPrice = $item->price;

        $this->assertSame($firstPrice, $secondPrice);
    }

    #[Test]
    public function it_recalculates_price_when_quantity_changes(): void
    {
        $item = OrderItemMother::some(quantity: 2, unitPrice: new Price(1000, Currency::new('PLN')));

        $this->assertTrue(new Price('2000', Currency::new('PLN'))->equals($item->price));

        $item->quantity = 3;

        $this->assertTrue(new Price('3000', Currency::new('PLN'))->equals($item->price));
    }

    #[Test]
    public function it_allows_to_add_price_adjustments(): void
    {
        $item = OrderItemMother::some(quantity: 2, unitPrice: new Price(1000, Currency::new('PLN')));

        $this->assertTrue($item->priceAdjustments->isEmpty());

        $item->addPriceAdjustment($firstAdjustment = PriceAdjustmentMother::some());
        $item->addPriceAdjustment($secondAdjustment = PriceAdjustmentMother::some());

        $this->assertTrue($item->priceAdjustments->contains($firstAdjustment));
        $this->assertTrue($item->priceAdjustments->contains($secondAdjustment));

        $item->removePriceAdjustment($firstAdjustment);

        $this->assertFalse($item->priceAdjustments->contains($firstAdjustment));
        $this->assertTrue($item->priceAdjustments->contains($secondAdjustment));
    }
}
