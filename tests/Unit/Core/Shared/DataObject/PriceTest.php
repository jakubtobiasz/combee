<?php declare(strict_types=1);

namespace Tests\Unit\Core\Shared\DataObject;

use Combee\Core\Shared\DataObject\Currency;
use Combee\Core\Shared\DataObject\Price;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PriceTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $price = new Price(1000, new Currency('EUR'));

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    public function it_tells_if_it_is_zero(): void
    {
        $price = new Price(0, new Currency('EUR'));

        $this->assertTrue($price->isZero);
    }

    #[Test]
    public function it_tells_if_number_is_positive(): void
    {
        $price = new Price(1000, new Currency('EUR'));

        $this->assertTrue($price->isPositive);
    }

    #[Test]
    public function it_tells_if_number_is_negative(): void
    {
        $price = new Price(-1000, new Currency('EUR'));

        $this->assertTrue($price->isNegative);
    }

    #[Test]
    public function it_adds_prices(): void
    {
        $price = new Price(1000, new Currency('EUR'));
        $otherPrice = new Price(1000, new Currency('EUR'));

        $result = $price->add($otherPrice);

        $this->assertSame('2000', $result->amount);
        $this->assertSame('EUR', $result->currency->code);
    }

    #[Test]
    public function it_subtracts_prices(): void
    {
        $price = new Price(1000, new Currency('EUR'));
        $otherPrice = new Price(900, new Currency('EUR'));

        $result = $price->subtract($otherPrice);

        $this->assertSame('100', $result->amount);
        $this->assertSame('EUR', $result->currency->code);
    }

    #[Test]
    public function it_multiplies_prices(): void
    {
        $price = new Price(1000, new Currency('EUR'));

        $result = $price->multiply(2);

        $this->assertSame('2000', $result->amount);
        $this->assertSame('EUR', $result->currency->code);
    }

    #[Test]
    public function it_divides_prices(): void
    {
        $price = new Price(1000, new Currency('EUR'));

        $result = $price->divide(2);

        $this->assertSame('500', $result->amount);
        $this->assertSame('EUR', $result->currency->code);
    }

    #[Test]
    public function it_modulos_prices(): void
    {
        $price = new Price(1011, new Currency('EUR'));

        $result = $price->mod(40);

        $this->assertSame('11', $result->amount);
        $this->assertSame('EUR', $result->currency->code);
    }
}
