<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Model;

use Combee\Core\Ordering\Model\Exception\NegativeOrZeroQuantityException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Helper\MotherObject\OrderItemMother;

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
}
