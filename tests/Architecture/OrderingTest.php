<?php declare(strict_types=1);

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

final class OrderingTest
{
    public function test_ordering_depends_only_on_its_own_classes(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace('Combee\Core\Ordering'))
            ->canOnlyDependOn()
            ->classes(Selector::inNamespace('Combee\Core\Ordering'))
            ->because('Ordering should not depend on other modules')
        ;
    }
}