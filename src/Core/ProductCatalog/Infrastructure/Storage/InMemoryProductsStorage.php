<?php declare(strict_types=1);

namespace Combee\Core\ProductCatalog\Infrastructure\Storage;

use Combee\Core\ProductCatalog\Contract\Model\ProductContract;
use Combee\Core\ProductCatalog\Contract\Storage\ProductsStorageContract;
use Combee\Core\Shared\Collection\ArrayCollection;
use Combee\Core\Shared\Contract\Collection;
use Combee\Core\Shared\Model\Identifier\ProductIdentifier;

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
