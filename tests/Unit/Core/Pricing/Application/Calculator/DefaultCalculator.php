<?php declare(strict_types=1);

namespace Tests\Unit\Core\Pricing\Integration\Calculator;

use Recode\Ecommerce\Core\Pricing\Application\Calculator\DefaultCalculator;
use Recode\Ecommerce\Core\Shared\Contract\Priceable;
use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class DefaultCalculatorTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $calculator = new DefaultCalculator();

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    public function it_returns_priceable_price(): void
    {
        $calculator = new DefaultCalculator();
        $expectedPrice = new Price(1000, new Currency('EUR'));

        $priceable = $this->createMock(Priceable::class);
        $priceable->price = $expectedPrice;

        $result = $calculator->calculate($priceable);

        $this->assertSame($expectedPrice, $result);
    }

    #[Test]
    public function it_always_supports_any_priceable(): void
    {
        $calculator = new DefaultCalculator();
        $priceable = $this->createMock(Priceable::class);

        $this->assertTrue($calculator->supports($priceable));
    }
}
