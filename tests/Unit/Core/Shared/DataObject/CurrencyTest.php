<?php declare(strict_types=1);

namespace Tests\Unit\Core\Shared\DataObject;

use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\Exception\InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class CurrencyTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $currency = new Currency('EUR');

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    public function it_can_be_created_with_static_factory_method(): void
    {
        $currency = Currency::new('USD');

        $this->assertSame('USD', $currency->code);
    }

    #[Test]
    public function it_returns_currency_code_as_string(): void
    {
        $currency = new Currency('GBP');

        $this->assertSame('GBP', $currency->code);
    }

    #[Test]
    public function it_throws_exception_for_invalid_currency_code(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Currency "INVALID" does not exist.');

        $currency = new Currency('INVALID');
    }
}
