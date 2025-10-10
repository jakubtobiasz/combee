<?php /** @noinspection PhpObjectFieldsAreOnlyWrittenInspection */

declare(strict_types=1);

namespace Tests\Unit\Core\ProductCatalog\Model;

use Combee\Core\ProductCatalog\Model\Exception\NegativeOrZeroPriceException;
use Combee\Core\Shared\DataObject\Currency;
use Combee\Core\Shared\DataObject\Price;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Helper\MotherObject\ProductMother;

final class ProductTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $product = ProductMother::some();

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    #[DataProvider('provideInvalidPrices')]
    public function it_prevents_from_creating_product_with_invalid_price(Price $price): void
    {
        $this->expectException(NegativeOrZeroPriceException::class);
        $this->expectExceptionMessage('Price must be greater than zero.');

        $product = ProductMother::some(price: $price);
    }

    #[Test]
    #[DataProvider('provideInvalidPrices')]
    public function it_prevents_changing_the_price_to_invalid_one(Price $price): void
    {
        $this->expectException(NegativeOrZeroPriceException::class);
        $this->expectExceptionMessage('Price must be greater than zero.');

        $product = ProductMother::some();
        $product->price = $price;
    }

    /**
     * @return iterable<array<Price>>
     */
    public static function provideInvalidPrices(): iterable
    {
        yield [Price::new(0, Currency::new('PLN'))];
        yield [Price::new(-1, Currency::new('PLN'))];
    }
}
