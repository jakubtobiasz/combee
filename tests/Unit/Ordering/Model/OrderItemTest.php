<?php declare(strict_types=1);

namespace Tests\Unit\Ordering\Model;

use Combee\Core\Ordering\Model\Exception\NegativeOrZeroQuantityException;
use Combee\Core\Ordering\Model\OrderItem;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class OrderItemTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $item = new OrderItem(Uuid::uuid4(), 'OMG', 1);

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    #[DataProvider('provideInvalidQuantity')]
    public function it_prevents_creating_an_item_with_negative_quantity(int $quantity): void
    {
        $this->expectException(NegativeOrZeroQuantityException::class);
        $this->expectExceptionMessage('Quantity must be greater than zero.');

        $item = new OrderItem(Uuid::uuid4(), 'OMG', $quantity);
    }

    /**
     * @return iterable<array<int>>
     */
    public static function provideInvalidQuantity(): iterable
    {
        yield 'negative' => [-1];
        yield 'zero' => [0];
    }
}
