<?php declare(strict_types=1);

namespace Tools\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Recode\Ecommerce\Core\ProductCatalog\Contract\Storage\ProductsStorageContract;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Tests\Helper\MotherObject\ProductMother;

class ProductCatalogSetupContext implements Context
{
    public function __construct(
        private readonly ProductsStorageContract $productsStorage,
    ) {
    }

    #[Given('there is a product with SKU :sku priced at :price')]
    public function thereIsProductWithSkuPricedAt(string $sku, Price $price): void
    {
        $product = ProductMother::some(sku: $sku, price: $price);

        $this->productsStorage->store($product);
    }
}