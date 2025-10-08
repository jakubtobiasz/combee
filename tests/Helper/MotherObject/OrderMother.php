<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Combee\Core\Model\Identifier\OrderIdentifier;
use Combee\Ordering\Contract\Model\OrderContract;
use Combee\Ordering\Contract\Model\OrderItemContract;
use Combee\Ordering\Model\Order;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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
