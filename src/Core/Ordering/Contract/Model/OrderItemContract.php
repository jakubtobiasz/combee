<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Model;

use Recode\Ecommerce\Core\Shared\Contract\Collection;
use Recode\Ecommerce\Core\Shared\Contract\PriceAdjustmentContract;
use Recode\Ecommerce\Core\Shared\DataObject\Price;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderItemIdentifier;

interface OrderItemContract
{
    public OrderItemIdentifier $uuid { get; }

    public string $productSku { get; }

    public Price $unitPrice { get; }

    public int $quantity { get; set; }

    public Price $price { get; }

    /** @var Collection<array-key, PriceAdjustmentContract> */
    public Collection $priceAdjustments { get; }

    public function addPriceAdjustment(PriceAdjustmentContract $priceAdjustment): void;

    public function removePriceAdjustment(PriceAdjustmentContract $priceAdjustment): void;
}
