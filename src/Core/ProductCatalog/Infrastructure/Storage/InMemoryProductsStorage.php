<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\ProductCatalog\Infrastructure\Storage;

use Recode\Ecommerce\Core\ProductCatalog\Contract\Model\ProductContract;
use Recode\Ecommerce\Core\ProductCatalog\Contract\Storage\ProductsStorageContract;
use Recode\Ecommerce\Core\Shared\Collection\ArrayCollection;
use Recode\Ecommerce\Core\Shared\Contract\Collection;
use Recode\Ecommerce\Core\Shared\Model\Identifier\ProductIdentifier;

class InMemoryProductsStorage implements ProductsStorageContract
{
    /** @var Collection<array-key, ProductContract> */
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function findBySku(string $sku): ?ProductContract
    {
        return $this->products->findFirst(fn (string $_, ProductContract $product) => $product->sku === $sku);
    }

    public function findByIdentifier(ProductIdentifier $uuid): ?ProductContract
    {
        return $this->products->get($uuid->toString());
    }

    public function findAll(): Collection
    {
        return $this->products;
    }

    public function store(ProductContract $product): void
    {
        $this->products->set($product->uuid->toString(), $product);
    }
}
