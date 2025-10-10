<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Model\AddItemStrategy;

use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Combee\Core\Ordering\Model\AddItemStrategy\MergeSameSkuItemsStrategy;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Helper\MotherObject\OrderItemMother;

final class MergeSameSkuItemsStrategyTest extends TestCase
{
    #[Test]
    public function it_adds_non_duplicated_item_to_collection(): void
    {
        /** @var ArrayCollection<array-key, OrderItemContract> $items */
        $items = new ArrayCollection();

        $newItem = OrderItemMother::some();

        $strategy = new MergeSameSkuItemsStrategy();
        $strategy->addItem($items, $newItem);

        $this->assertSame([$newItem], $items->toArray());
    }

    #[Test]
    public function it_increases_quantity_of_existing_item_while_adding_duplicate(): void
    {
        $existingItem = OrderItemMother::some(productSku: 'OMGYES', quantity: 3);

        /** @var ArrayCollection<array-key, OrderItemContract> $items */
        $items = new ArrayCollection([$existingItem]);

        $newItem = OrderItemMother::some(productSku: 'OMGYES', quantity: 2);

        $strategy = new MergeSameSkuItemsStrategy();
        $strategy->addItem($items, $newItem);

        $this->assertSame([$existingItem], $items->toArray());
        $this->assertSame(5, $existingItem->quantity);
    }
}
