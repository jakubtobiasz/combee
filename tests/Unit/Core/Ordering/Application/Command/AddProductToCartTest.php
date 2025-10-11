<?php declare(strict_types=1);

namespace Tests\Unit\Core\Ordering\Application\Command;

use Combee\Core\Ordering\Application\Command\AddProductToCart;
use Combee\Core\Ordering\Contract\Model\AddItemStrategy\AddItemStrategyContract;
use Combee\Core\Shared\Model\Identifier\OrderIdentifier;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use stdClass;

final class AddProductToCartTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $command = new AddProductToCart(OrderIdentifier::new(), 'OMG', 2);

        $this->assertSame('OMG', $command->sku);
        $this->assertSame(2, $command->quantity);
    }

    #[Test]
    public function it_throws_an_exception_if_strategy_class_is_not_implementing_required_interface(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Strategy "%s" must implement "%s"', stdClass::class, AddItemStrategyContract::class),
        );

        /** @phpstan-ignore argument.type */
        $command = new AddProductToCart(OrderIdentifier::new(), 'OMG', 2, strategy: stdClass::class);
    }
}
