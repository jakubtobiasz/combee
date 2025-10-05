<?php declare(strict_types=1);

namespace Tests\Unit\Ordering\Model;

use Combee\Core\Ordering\Model\Order;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class OrderTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $order = new Order(Uuid::uuid4());

        $this->expectNotToPerformAssertions();
    }
}