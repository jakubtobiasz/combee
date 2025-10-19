<?php declare(strict_types=1);

namespace Tests\Architecture;

use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

abstract class AbstractComponentTest
{
    /**
     * @return non-empty-string
     */
    abstract protected function getComponentName(): string;

    /**
     * @return non-empty-string
     */
    abstract protected function getComponentNamespace(): string;

    public function test_component_depends_only_on_its_own_and_shared_types(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace($this->getComponentNamespace()))
            ->excluding(
                Selector::inNamespace(sprintf('%s\Infrastructure', $this->getComponentNamespace())),
                Selector::inNamespace(sprintf('%s\Integration', $this->getComponentNamespace())),
            )
            ->canOnlyDependOn()
            ->classes(
                Selector::inNamespace($this->getComponentNamespace()),
                Selector::inNamespace('Combee\Core\Shared'),
            )
            ->because(sprintf('%s should not depend on other modules', $this->getComponentName()))
        ;
    }

    public function test_component_integration_layer_depends_only_on_specific_types(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace(sprintf('%s\Integration', $this->getComponentNamespace())))
            ->canOnlyDependOn()
            ->classes(
                Selector::inNamespace($this->getComponentNamespace()),
                Selector::inNamespace('Combee\Core\Shared'),
                Selector::inNamespace('/^Combee\\\\Core\\\\\w+\\\\Contract.*/', true),
            )
            ->because(sprintf('%s integration layer should only depend on specific types', $this->getComponentName()))
        ;
    }

    public function test_component_infrastructure_layer_depends_on_any_types(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::inNamespace(sprintf('%s\Infrastructure', $this->getComponentNamespace())))
            ->canOnlyDependOn()
            ->classes(
                Selector::inNamespace($this->getComponentNamespace()),
                Selector::inNamespace('Combee\Core\Shared'),
                Selector::withFilepath('/vendor/.*', true),
            )
            ->because(sprintf('%s infrastructure layer should depend on any types', $this->getComponentName()))
        ;
    }
}
