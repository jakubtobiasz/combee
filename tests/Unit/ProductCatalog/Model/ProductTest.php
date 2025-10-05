<?php declare(strict_types=1);

namespace Tests\Unit\ProductCatalog\Model;

use Combee\Core\ProductCatalog\Model\Product;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

final class ProductTest extends TestCase
{
    #[Test]
    public function it_can_be_created(): void
    {
        $product = new Product(Uuid::uuid4(), 'OMG');

        $this->expectNotToPerformAssertions();
    }
}