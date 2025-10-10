<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Model;

use Combee\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Combee\Core\Ordering\Contract\Model\Exception\OrderSealedException;
use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Helper\MotherObject\OrderItemMother;
use Tests\Helper\MotherObject\OrderMother;

final class OrderTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $order = OrderMother::some();

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    public function it_can_be_created_with_items(): void
    {
        /** @var ArrayCollection<array-key, OrderItemContract> $items */
        $items = new ArrayCollection([OrderItemMother::some(productSku: 'OMGG'), OrderItemMother::some(productSku: 'LOL')]);

        $order = OrderMother::some(items: $items);

        $this->assertSame($items, $order->items);
    }

    #[Test]
    public function it_allows_to_add_items_using_strategy(): void
    {
        $order = OrderMother::some(items: $items = new ArrayCollection());

        $orderItem = $this->createMock(OrderItemContract::class);

        $strategy = $this->createMock(AddItemStrategyContract::class);
        $strategy->expects($this->once())->method('addItem')->with($items, $orderItem);

        $order->addItem($orderItem, $strategy);
    }

    #[Test]
    public function it_prevents_adding_items_to_sealed_order(): void
    {
        $this->expectException(OrderSealedException::class);
        $this->expectExceptionMessage('Order is sealed and cannot be modified');

        $orderItem = $this->createMock(OrderItemContract::class);

        OrderMother::some(state: 'placed')->addItem(
            $orderItem,
            $this->createMock(AddItemStrategyContract::class),
        );
    }
}
