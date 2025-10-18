# Behat with Laravel Container

This Behat setup uses Laravel's Illuminate Container for dependency injection and service management.

## Features

- **Automatic Autowiring**: Context constructor dependencies are automatically resolved from the container
- **Laravel-Native Configuration**: Use familiar Laravel Container syntax for service registration
- **Flexible Setup**: Supports both Laravel-style bootstrap files and Symfony-style service configuration

## Configuration

The extension is configured in `behat.php`:

```php
new Extension(ContainerExtension::class, [
    'bootstrap' => 'tools/behat/config/bootstrap.php',
])
```

### Options

- `bootstrap` (optional): Path to a Laravel-style bootstrap file for container configuration
- `services` (optional): Path to a Symfony-style services configuration file (default: `config/services.php`)

## Service Registration

### Laravel-Style Bootstrap (Recommended)

Create a `bootstrap.php` file that returns a closure receiving the Container:

```php
<?php

use Illuminate\Container\Container;
use App\Storage\ProductsStorageContract;
use App\Storage\InMemoryProductsStorage;

return static function (Container $container): void {
    // Register a singleton
    $container->singleton(ProductsStorageContract::class, InMemoryProductsStorage::class);

    // Register with a factory
    $container->bind(SomeService::class, function ($container) {
        return new SomeService($container->make(Dependency::class));
    });

    // Register an instance
    $container->instance(Config::class, new Config(['key' => 'value']));
};
```

### Autowiring

The extension automatically resolves constructor dependencies for all Behat contexts:

```php
<?php

use Behat\Behat\Context\Context;

class ProductContext implements Context
{
    // Dependencies are automatically resolved!
    public function __construct(
        private readonly ProductsStorageContract $productsStorage,
        private readonly CartStorageContract $cartStorage,
    ) {}

    #[Given('there is a product :name')]
    public function thereIsProduct(string $name): void
    {
        $product = new Product($name);
        $this->productsStorage->store($product);
    }
}
```

## How It Works

1. **ContainerExtension** creates an Illuminate Container instance
2. The bootstrap file registers services in the container
3. **IlluminateArgumentResolver** resolves context constructor arguments using the container
4. Contexts are instantiated with their dependencies automatically

## Benefits Over Symfony Container

- **Simpler syntax**: Laravel Container has a more intuitive API
- **Better autowiring**: Automatic resolution of constructor dependencies
- **Familiar for Laravel developers**: Use the same patterns you know from Laravel
- **Less configuration**: No need to manually define every service

## Example

See `config/bootstrap.php` for a complete example of service registration.
