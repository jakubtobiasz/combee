<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderItemContract;
use Recode\Ecommerce\Core\Ordering\Model\Order;
use Recode\Ecommerce\Core\Shared\Collection\ArrayCollection;
use Recode\Ecommerce\Core\Shared\Contract\Collection;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

class OrderMother
{
    /**
     * @param Collection<array-key, OrderItemContract>|null $items
     */
    public static function some(?OrderIdentifier $uuid = null, ?Collection $items = null, string $state = 'cart'): OrderContract
    {
        return new Order(
            $uuid ?? OrderIdentifier::new(),
            $items ?? new ArrayCollection(),
            $state,
        );
    }
}
