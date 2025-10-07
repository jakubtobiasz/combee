<?php /** @noinspection PhpObjectFieldsAreOnlyWrittenInspection */

declare(strict_types=1);

namespace Tests\Unit\ProductCatalog\Model;

use Combee\ProductCatalog\Model\Exception\NegativeOrZeroPriceException;
use Combee\ProductCatalog\Model\Product;
use Money\Money;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class ProductTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $product = new Product(Uuid::uuid4(), 'OMG', Money::PLN(150));

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    #[DataProvider('provideInvalidPrices')]
    public function it_prevents_from_creating_product_with_invalid_price(Money $price): void
    {
        $this->expectException(NegativeOrZeroPriceException::class);
        $this->expectExceptionMessage('Price must be greater than zero.');

        $product = new Product(Uuid::uuid4(), 'OMG', $price);
    }

    #[Test]
    #[DataProvider('provideInvalidPrices')]
    public function it_prevents_changing_the_price_to_invalid_one(Money $price): void
    {
        $this->expectException(NegativeOrZeroPriceException::class);
        $this->expectExceptionMessage('Price must be greater than zero.');

        $product = new Product(Uuid::uuid4(), 'OMG', Money::PLN(150));
        $product->price = $price;
    }

    /**
     * @return iterable<array<Money>>
     */
    public static function provideInvalidPrices(): iterable
    {
        yield [Money::PLN(0)];
        yield [Money::PLN(-1)];
    }
}
