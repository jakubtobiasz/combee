<?php declare(strict_types=1);

namespace Tools\Behat\Extension\Container;

use Behat\Behat\Context\ServiceContainer\ContextExtension;
use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Illuminate\Container\Container as IlluminateContainer;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class ContainerExtension implements Extension
{
    private const CONTAINER_ID = 'alphpaca_behat.illuminate_container';
    private const ARGUMENT_RESOLVER_ID = 'alphpaca_behat.argument_resolver';

    public function getConfigKey(): string
    {
        return 'alphpaca_behat_container';
    }

    public function configure(ArrayNodeDefinition $builder): void
    {
        $builder
            ->children()
                ->scalarNode('bootstrap')
                    ->info('Path to Laravel-style bootstrap file for container configuration')
                    ->defaultNull()
                ->end()
            ->end()
        ;
    }

    public function load(ContainerBuilder $container, array $config): void
    {
        $containerDefinition = new Definition(IlluminateContainer::class);
        $containerDefinition->setFactory([self::class, 'createIlluminateContainer']);
        $containerDefinition->setArguments([
            '%paths.base%',
            $config['bootstrap'],
        ]);
        $container->setDefinition(self::CONTAINER_ID, $containerDefinition);

        $resolverDefinition = new Definition(IlluminateArgumentResolver::class);
        $resolverDefinition->addArgument(new Reference(self::CONTAINER_ID));
        $resolverDefinition->addTag(ContextExtension::ARGUMENT_RESOLVER_TAG, ['priority' => 50]);
        $container->setDefinition(self::ARGUMENT_RESOLVER_ID, $resolverDefinition);
    }

    public function process(ContainerBuilder $container): void
    {
    }

    public function initialize(ExtensionManager $extensionManager): void
    {
    }

    /**
     * Factory method to create and configure the Illuminate Container
     */
    public static function createIlluminateContainer(string $basePath, ?string $bootstrapPath): IlluminateContainer
    {
        $container = new IlluminateContainer();

        $container->instance(IlluminateContainer::class, $container);

        if ($bootstrapPath !== null) {
            $fullBootstrapPath = $basePath . '/' . $bootstrapPath;
            if (file_exists($fullBootstrapPath)) {
                self::loadBootstrapFile($container, $fullBootstrapPath);
            }
        }

        return $container;
    }

    /**
     * Load a Laravel-style bootstrap file that receives the container
     */
    private static function loadBootstrapFile(IlluminateContainer $container, string $filePath): void
    {
        $callback = require $filePath;

        if (is_callable($callback)) {
            $callback($container);
        }
    }
}