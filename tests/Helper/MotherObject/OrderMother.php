<?php declare(strict_types=1);

namespace Tests\Helper\MotherObject;

use Combee\Core\Ordering\Contract\Model\OrderContract;
use Combee\Core\Ordering\Contract\Model\OrderItemContract;
use Combee\Core\Ordering\Model\Order;
use Combee\Core\Shared\Model\Identifier\OrderIdentifier;
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
