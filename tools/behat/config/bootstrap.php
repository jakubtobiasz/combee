<?php declare(strict_types=1);

use Recode\Ecommerce\Core\Ordering\Application\Command\Handler\AddProductToCartHandler;
use Recode\Ecommerce\Core\Ordering\Contract\Model\Factory\OrderItemFactoryContract;
use Recode\Ecommerce\Core\Ordering\Contract\Provider\ProductDataProviderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Storage\CartStorageContract;
use Recode\Ecommerce\Core\Ordering\Infrastructure\Storage\InMemoryCartStorage;
use Recode\Ecommerce\Core\Ordering\Model\Factory\OrderItemFactory;
use Recode\Ecommerce\Core\ProductCatalog\Contract\Storage\ProductsStorageContract;
use Recode\Ecommerce\Core\ProductCatalog\Infrastructure\Storage\InMemoryProductsStorage;
use Recode\Ecommerce\Core\ProductCatalog\Integration\Ordering\Provider\ProductDataProvider;
use Illuminate\Container\Container;
use Tools\Behat\Service\SharedStorage;
use Tools\Behat\Service\SharedStorageContract;

/**
 * Laravel Container Bootstrap File
 *
 * This file is used to register services in the Laravel Container.
 * It provides a cleaner, more Laravel-native way to configure dependencies.
 */
return static function (Container $container): void {
    // Register storage implementations
    $container->singleton(ProductsStorageContract::class, InMemoryProductsStorage::class);
    $container->singleton(CartStorageContract::class, InMemoryCartStorage::class);
    $container->singleton(SharedStorageContract::class, SharedStorage::class);

    $container->singleton(AddProductToCartHandler::class);

    $container->singleton(ProductDataProviderContract::class, ProductDataProvider::class);
    $container->singleton(OrderItemFactoryContract::class, OrderItemFactory::class);

    // Enable autowiring for all Behat contexts
    // The ArgumentResolver will automatically resolve constructor dependencies

    // You can also bind specific implementations:
    // $container->bind(SomeInterface::class, SomeImplementation::class);

    // Or register singletons:
    // $container->singleton(SomeService::class, function ($container) {
    //     return new SomeService($container->make(Dependency::class));
    // });

    // Or register instances:
    // $container->instance(SomeService::class, new SomeService());
};
