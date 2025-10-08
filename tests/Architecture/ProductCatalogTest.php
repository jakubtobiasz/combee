<?php declare(strict_types=1);

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

final class ProductCatalogTest
{
    public function test_product_catalog_depends_only_on_its_own_classes(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('Combee\ProductCatalog'))
            ->excluding(Selector::inNamespace('Combee\ProductCatalog\Integration'))
            ->canOnlyDependOn()
            ->classes(
                Selector::inNamespace('Combee\Core'),
                Selector::inNamespace('Combee\ProductCatalog'),
                Selector::inNamespace('Doctrine\Common\Collections'),
                Selector::inNamespace('Money'),
            )
            ->because('Product catalog should not depend on other modules')
        ;
    }

    /**
     * @return iterable<Rule>
     */
    public function test_ordering_integration_depends_only_on_product_catalog_and_ordering_contracts(): iterable
    {
        yield PHPat::rule()
            ->classes(Selector::inNamespace('Combee\ProductCatalog\Integration\Ordering'))
            ->shouldNotDependOn()
            ->classes(Selector::inNamespace('Combee\ProductCatalog\Integration'))
            ->excluding(Selector::inNamespace('Combee\ProductCatalog\Integration\Ordering'))
            ->because('Ordering integration should not depend on other integration modules')
        ;

        yield PHPat::rule()
            ->classes(Selector::inNamespace('Combee\ProductCatalog\Integration\Ordering'))
            ->canOnlyDependOn()
            ->classes(
                Selector::inNamespace('Combee\Ordering\Contract'),
                Selector::inNamespace('Combee\ProductCatalog'),
                Selector::inNamespace('Combee\ProductCatalog\Integration\Ordering'),
            )
            ->because('Product catalog should not depend on other layers than their own classes and known contracts')
        ;
    }
}
