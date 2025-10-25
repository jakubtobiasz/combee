<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Application\Processor;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Recode\Ecommerce\Core\Ordering\Application\Processor\AggregateCartProcessor;
use Recode\Ecommerce\Core\Ordering\Contract\Processor\CartProcessorContract;
use Recode\Ecommerce\Core\Shared\Exception\InvalidArgumentException;
use Tests\Helper\MotherObject\OrderMother;

final class AggregateCartProcessorTest extends TestCase
{
    #[Test]
    public function it_iterates_over_passed_processors(): void
    {
        $order = OrderMother::some();

        $firstProcessor = $this->createMock(CartProcessorContract::class);
        $firstProcessor->expects($this->once())->method('process')->with($order);

        $secondProcessor = $this->createMock(CartProcessorContract::class);
        $secondProcessor->expects($this->once())->method('process')->with($order);

        $this->createTestSubject([$firstProcessor, $secondProcessor])->process($order);
    }

    #[Test]
    public function it_throws_an_exception_when_at_least_one_subprocessor_passed_not_implementing_required_contract(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('All subprocessors must implement "Recode\Ecommerce\Core\Ordering\Contract\Processor\CartProcessorContract".');

        $order = OrderMother::some();

        /**
         * @var CartProcessorContract $firstProcessor
         * @phpstan-ignore varTag.nativeType
         */
        $firstProcessor = $this->createMock(\stdClass::class);
        $secondProcessor = $this->createMock(CartProcessorContract::class);

        $this->createTestSubject([$firstProcessor, $secondProcessor])->process($order);
    }

    /**
     * @param array<CartProcessorContract> $subprocessors
     */
    private function createTestSubject(array $subprocessors): CartProcessorContract
    {
        return new AggregateCartProcessor($subprocessors);
    }
}
