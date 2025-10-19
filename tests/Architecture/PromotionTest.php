<?php declare(strict_types=1);

namespace Tests\Architecture;

class PromotionTest extends AbstractComponentTest
{
    protected function getComponentName(): string
    {
        return 'Promotion';
    }

    protected function getComponentNamespace(): string
    {
        return 'Recode\Ecommerce\Core\Promotion';
    }
}
