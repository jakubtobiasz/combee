<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Model\AddItemStrategy;

use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Combee\Core\Ordering\Model\AddItemStrategy\AddAsNewItemStrategy;
use Combee\Core\Shared\Collection\ArrayCollection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Helper\MotherObject\OrderItemMother;

final class AddAsNewItemStrategyTest extends TestCase
{
    #[Test]
    public function it_adds_item_to_collection(): void
    {
        /** @var ArrayCollection<array-key, OrderItemContract> $items */
        $items = new ArrayCollection();

        $newItem = OrderItemMother::some();

        $strategy = new AddAsNewItemStrategy();
        $strategy->addItem($items, $newItem);

        $this->assertSame([$newItem], $items->toArray());
    }
}
