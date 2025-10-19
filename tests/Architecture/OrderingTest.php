<?php declare(strict_types=1);

namespace Tests\Architecture;

final class OrderingTest extends AbstractComponentTest
{
    protected function getComponentName(): string
    {
        return 'Ordering';
    }

    protected function getComponentNamespace(): string
    {
        return 'Recode\Ecommerce\Core\Ordering';
    }
}
