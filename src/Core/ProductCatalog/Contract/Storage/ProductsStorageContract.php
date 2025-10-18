<?php declare(strict_types=1);

namespace Combee\Core\ProductCatalog\Contract\Storage;

use Combee\Core\ProductCatalog\Contract\Model\ProductContract;
use Combee\Core\Shared\Contract\Collection;
use Combee\Core\Shared\Model\Identifier\ProductIdentifier;

interface ProductsStorageContract
{
    public function findBySku(string $sku): ?ProductContract;

    public function findByIdentifier(ProductIdentifier $uuid): ?ProductContract;

    /**
     * @return Collection<array-key, ProductContract>
     */
    public function findAll(): Collection;

    public function store(ProductContract $product): void;
}
