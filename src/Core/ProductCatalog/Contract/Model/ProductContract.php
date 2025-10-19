<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\ProductCatalog\Contract\Model;

use Recode\Ecommerce\Core\Shared\Contract\Priceable;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Model\Identifier\ProductIdentifier;

interface ProductContract extends Priceable
{
    public ProductIdentifier $uuid { get; }

    public string $sku { get; }

    public Price $price { get; set; }
}
