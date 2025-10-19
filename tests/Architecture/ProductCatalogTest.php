<?php declare(strict_types=1);

namespace Tests\Architecture;

final class ProductCatalogTest extends AbstractComponentTest
{
    protected function getComponentName(): string
    {
        return 'Product Catalog';
    }

    protected function getComponentNamespace(): string
    {
        return 'Combee\Core\ProductCatalog';
    }
}
