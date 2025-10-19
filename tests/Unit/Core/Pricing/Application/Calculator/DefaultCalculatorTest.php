<?php declare(strict_types=1);

namespace Tests\Unit\Core\Pricing\Application\Calculator;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Recode\Ecommerce\Core\Pricing\Application\Calculator\DefaultCalculator;
use Recode\Ecommerce\Core\Shared\Contract\Priceable;
use Recode\Ecommerce\Core\Shared\DataObject\Currency;
use Recode\Ecommerce\Core\Shared\DataObject\Price;

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

        $priceable = $this->createPriceable(new Price(1000, new Currency('EUR')));

        $calculatedPrice = $calculator->calculate($priceable);

        $this->assertTrue(new Price(1000, new Currency('EUR'))->equals($calculatedPrice));
    }

    #[Test]
    public function it_always_supports_any_priceable(): void
    {
        $calculator = new DefaultCalculator();
        $priceable = $this->createMock(Priceable::class);

        $this->assertTrue($calculator->supports($priceable));
    }

    private function createPriceable(Price $price): Priceable
    {
        return new readonly class ($price) implements Priceable {
            public function __construct(
                protected(set) Price $price
            ) {
            }
        };
    }
}
