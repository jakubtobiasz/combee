<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\ProductCatalog\Contract\Storage;

use Recode\Ecommerce\Core\ProductCatalog\Contract\Model\ProductContract;
use Recode\Ecommerce\Core\Shared\Contract\Collection;
use Recode\Ecommerce\Core\Shared\Model\Identifier\ProductIdentifier;

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
