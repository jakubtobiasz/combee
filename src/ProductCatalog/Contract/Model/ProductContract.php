<?php declare(strict_types=1);

namespace Combee\ProductCatalog\Contract\Model;

use Combee\Core\Contract\Priceable;
use Combee\Core\Model\Identifier\ProductIdentifier;
use Money\Money;

interface ProductContract extends Priceable
{
    public ProductIdentifier $uuid { get; }

    public string $sku { get; }

    public Money $price { get; set; }
}
