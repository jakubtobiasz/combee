<?php declare(strict_types=1);

namespace Tests\Unit\Core\Pricing\Integration\Calculator;

use Combee\Core\Pricing\Calculator\AggregateCalculator;
use Combee\Core\Pricing\Contract\CalculatorContract;
use Combee\Core\Pricing\Contract\Exception\NoSupportedCalculatorException;
use Combee\Core\Shared\Contract\Priceable;
use Combee\Core\Shared\DataObject\Currency;
use Combee\Core\Shared\DataObject\Price;
use Combee\Core\Shared\Exception\InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class AggregateCalculatorTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $calculator = new AggregateCalculator([]);

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    public function it_can_be_created_with_calculators(): void
    {
        $calculator1 = $this->createMock(CalculatorContract::class);
        $calculator2 = $this->createMock(CalculatorContract::class);

        $aggregateCalculator = new AggregateCalculator([$calculator1, $calculator2]);

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    public function it_throws_exception_if_calculator_does_not_implement_contract(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Calculator must implement "Combee\Core\Pricing\Contract\CalculatorContract".');

        $invalidCalculator = new \stdClass();

        new AggregateCalculator([$invalidCalculator]);
    }

    #[Test]
    public function it_delegates_calculation_to_first_supporting_calculator(): void
    {
        $expectedPrice = new Price(1500, new Currency('EUR'));
        $priceable = $this->createMock(Priceable::class);

        $calculator1 = $this->createMock(CalculatorContract::class);
        $calculator1->expects($this->once())
            ->method('supports')
            ->with($priceable, [])
            ->willReturn(false);
        $calculator1->expects($this->never())
            ->method('calculate');

        $calculator2 = $this->createMock(CalculatorContract::class);
        $calculator2->expects($this->once())
            ->method('supports')
            ->with($priceable, [])
            ->willReturn(true);
        $calculator2->expects($this->once())
            ->method('calculate')
            ->with($priceable, [])
            ->willReturn($expectedPrice);

        $calculator3 = $this->createMock(CalculatorContract::class);
        $calculator3->expects($this->never())
            ->method('supports');
        $calculator3->expects($this->never())
            ->method('calculate');

        $aggregateCalculator = new AggregateCalculator([$calculator1, $calculator2, $calculator3]);

        $result = $aggregateCalculator->calculate($priceable);

        $this->assertSame($expectedPrice, $result);
    }

    #[Test]
    public function it_throws_exception_when_no_calculator_supports_priceable(): void
    {
        $this->expectException(NoSupportedCalculatorException::class);
        $this->expectExceptionMessage('No supported calculator found.');

        $priceable = $this->createMock(Priceable::class);

        $calculator1 = $this->createMock(CalculatorContract::class);
        $calculator1->method('supports')->willReturn(false);

        $calculator2 = $this->createMock(CalculatorContract::class);
        $calculator2->method('supports')->willReturn(false);

        $aggregateCalculator = new AggregateCalculator([$calculator1, $calculator2]);

        $aggregateCalculator->calculate($priceable);
    }

    #[Test]
    public function it_throws_exception_when_no_calculators_provided(): void
    {
        $this->expectException(NoSupportedCalculatorException::class);
        $this->expectExceptionMessage('No supported calculator found.');

        $priceable = $this->createMock(Priceable::class);

        $aggregateCalculator = new AggregateCalculator([]);

        $aggregateCalculator->calculate($priceable);
    }

    #[Test]
    public function it_always_supports_any_priceable(): void
    {
        $priceable = $this->createMock(Priceable::class);

        $aggregateCalculator = new AggregateCalculator([]);

        $this->assertTrue($aggregateCalculator->supports($priceable));
    }
}
