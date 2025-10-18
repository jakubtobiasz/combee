<?php declare(strict_types=1);

namespace Tools\Behat\Transform;

use Behat\Behat\Context\Context;
use Behat\Transformation\Transform;
use Combee\Core\ProductCatalog\Contract\Model\ProductContract;
use Combee\Core\ProductCatalog\Contract\Storage\ProductsStorageContract;

class ProductCatalogTransformContext implements Context
{
    public function __construct(
        private readonly ProductsStorageContract $productsStorage,
    ) {
    }

    #[Transform('/^"([^"]+)" product$/')]
    public function transformProductSku(string $productSku): ProductContract
    {
        return $this->productsStorage->findBySku($productSku);
    }
}