<?php declare(strict_types=1);

namespace Combee\Core\ProductCatalog\Contract\Model;

use Combee\Core\Shared\Contract\Priceable;
use Combee\Core\Shared\Model\Identifier\ProductIdentifier;
use Money\Money;

interface ProductContract extends Priceable
{
    public ProductIdentifier $uuid { get; }

    public string $sku { get; }

    public Money $price { get; set; }
}
