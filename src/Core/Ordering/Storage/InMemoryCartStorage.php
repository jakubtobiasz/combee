<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Storage;

use Combee\Core\Ordering\Contract\Model\OrderContract;
use Combee\Core\Ordering\Contract\Storage\CartStorageContract;
use Combee\Core\Shared\Collection\ArrayCollection;
use Combee\Core\Shared\Contract\Collection;
use Combee\Core\Shared\Model\Identifier\OrderIdentifier;

class InMemoryCartStorage implements CartStorageContract
{
    /** @var Collection<array-key, OrderContract> */
    private Collection $carts;

    public function __construct()
    {
        $this->carts = new ArrayCollection();
    }

    public function findByIdentifier(OrderIdentifier $identifier): ?OrderContract
    {
        return $this->carts->get($identifier->toString());
    }

    public function store(OrderContract $cart): void
    {
        $this->carts->set($cart->uuid->toString(), $cart);
    }
}
