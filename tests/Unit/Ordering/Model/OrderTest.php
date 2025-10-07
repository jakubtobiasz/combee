<?php declare(strict_types=1);

namespace Tests\Unit\Ordering\Model;

use Combee\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Combee\Ordering\Contract\Model\Exception\OrderSealedException;
use Combee\Ordering\Contract\Model\OrderItemContract;
use Combee\Ordering\Model\Order;
use Combee\Ordering\Model\OrderItem;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class OrderTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $order = new Order(Uuid::uuid4(), new ArrayCollection());

        $this->expectNotToPerformAssertions();
    }

    #[Test]
    public function it_can_be_created_with_items(): void
    {
        /** @var ArrayCollection<array-key, OrderItemContract> $items */
        $items = new ArrayCollection([new OrderItem(Uuid::uuid4(), 'OMG', 1), new OrderItem(Uuid::uuid4(), 'LOL', 1)]);

        $order = new Order(Uuid::uuid4(), $items);

        $this->assertSame($items, $order->items);
    }

    #[Test]
    public function it_allows_to_add_items_using_strategy(): void
    {
        $order = new Order(Uuid::uuid4(), $items = new ArrayCollection());

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

        new Order(Uuid::uuid4(), new ArrayCollection(), state: 'placed')->addItem(
            $orderItem,
            $this->createMock(AddItemStrategyContract::class),
        );
    }
}
