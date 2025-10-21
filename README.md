# Recode Ecommerce

A next-generation e-commerce engine powered by cutting-edge technology.

## Overview

Recode Ecommerce is a modern, modular e-commerce library built with PHP 8.4. It provides a flexible foundation for building e-commerce applications with a focus on clean architecture and domain-driven design.

## Features

- **Product Catalog Management**: Robust product management with pricing support
- **Order Processing**: Flexible ordering system with customizable item strategies
- **Pricing Engine**: Advanced pricing calculations with aggregate support
- **Clean Architecture**: Decoupled modules with clear contracts and boundaries
- **Type Safety**: Leveraging PHP 8.4 features for maximum type safety

## Requirements

- PHP 8.4 or higher
- Composer

## Installation

```bash
composer require recode/ecommerce
```

## Core Modules

### Product Catalog
Manages product data, storage, and retrieval with built-in validation.

### Ordering
Handles order creation, item management, and order processing with configurable strategies.

### Pricing
Provides flexible pricing calculations with support for custom calculators.

## Development

### Setup

```bash
# Install dependencies
composer install

# Update development tools
composer update-tools
```

### Testing

The project uses Pest for unit testing and Behat for behavior-driven development tests.

```bash
# Run unit tests
./tools/pest/vendor/bin/pest

# Run Behat tests
./tools/behat/vendor/bin/behat
```

### Code Quality

```bash
# Run static analysis
./tools/phpstan/vendor/bin/phpstan analyse

# Fix code style
./tools/php-cs-fixer/vendor/bin/php-cs-fixer fix

# Run mutation tests
./tools/infection/vendor/bin/infection
```

### Docker

The project includes Docker support for development:

```bash
docker compose up -d
```

## Architecture

The project follows a modular architecture with clear separation of concerns:

- **Contract**: Interfaces and contracts
- **Model**: Domain models and business logic
- **Application**: Application services and use cases
- **Infrastructure**: Storage implementations and external integrations
- **Integration**: Cross-module integration points

## Contributing

This project maintains high standards for code quality:

- All code must pass static analysis (PHPStan)
- Code style must conform to PHP-CS-Fixer rules
- Unit tests are required for new features
- Mutation testing coverage is monitored with Infection

## Author

Jacob Tobiasz (jacob@alphpaca.io)

## License

Please refer to the project's license file for licensing information.
