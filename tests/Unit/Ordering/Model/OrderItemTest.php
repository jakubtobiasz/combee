<?php declare(strict_types=1);

namespace Tests\Unit\Ordering\Model;

use Combee\Core\Ordering\Model\OrderItem;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class OrderItemTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $orderItem = new OrderItem(Uuid::uuid4(), 'OMG');

        $this->expectNotToPerformAssertions();
    }
}