<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Model;

use Combee\Core\Shared\Contract\Collection;
use Combee\Core\Shared\Contract\PriceAdjustmentContract;
use Combee\Core\Shared\DataObject\Price;
use Combee\Core\Shared\Model\Identifier\OrderItemIdentifier;

interface OrderItemContract
{
    public OrderItemIdentifier $uuid { get; }

    public string $productSku { get; }

    public Price $unitPrice { get; }

    public int $quantity { get; set; }

    /** @var Collection<array-key, PriceAdjustmentContract> */
    public Collection $priceAdjustments { get; }

    public function addPriceAdjustment(PriceAdjustmentContract $priceAdjustment): void;

    public function removePriceAdjustment(PriceAdjustmentContract $priceAdjustment): void;
}
