<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Application\Checker;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Recode\Ecommerce\Core\Ordering\Application\Checker\CartProcessingPossibilityChecker;
use Recode\Ecommerce\Core\Ordering\Contract\Checker\CartProcessingPossibilityCheckerContract;
use Recode\Ecommerce\Core\Ordering\Contract\Storage\CartStorageContract;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;
use Tests\Helper\MotherObject\OrderMother;

final class CartProcessingPossibilityCheckerTest extends TestCase
{
    private MockObject&CartStorageContract $cartStorage;

    protected function setUp(): void
    {
        $this->cartStorage = $this->createMock(CartStorageContract::class);
    }

    #[Test]
    public function it_returns_if_cart_can_be_processed(): void
    {
        $cartOrder = OrderMother::some(state: 'cart');
        $placedOrder = OrderMother::some(state: 'placed');

        $this->cartStorage->expects($this->exactly(2))
            ->method('findByIdentifier')
            ->willReturnMap([
                [$cartId = OrderIdentifier::new(), $cartOrder],
                [$placedOrderId = OrderIdentifier::new(), $placedOrder],
            ])
        ;
        $this->assertTrue($this->createTestSubject()->canBeProcessed($cartId));
        $this->assertTrue($this->createTestSubject()->canBeProcessed($cartOrder));
        $this->assertFalse($this->createTestSubject()->canBeProcessed($placedOrderId));
        $this->assertFalse($this->createTestSubject()->canBeProcessed($placedOrder));
    }

    #[Test]
    public function it_returns_false_if_cart_not_found(): void
    {
        $this->cartStorage
            ->expects($this->once())
            ->method('findByIdentifier')
            ->with($cartId = OrderIdentifier::new())
            ->willReturn(null)
        ;

        $this->assertFalse($this->createTestSubject()->canBeProcessed($cartId));
    }

    private function createTestSubject(): CartProcessingPossibilityCheckerContract
    {
        return new CartProcessingPossibilityChecker($this->cartStorage);
    }
}
