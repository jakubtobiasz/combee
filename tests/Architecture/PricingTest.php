<?php declare(strict_types=1);

namespace Tests\Architecture;

class PricingTest extends AbstractComponentTest
{
    protected function getComponentName(): string
    {
        return 'Pricing';
    }

    protected function getComponentNamespace(): string
    {
        return 'Combee\Core\Pricing';
    }
}
