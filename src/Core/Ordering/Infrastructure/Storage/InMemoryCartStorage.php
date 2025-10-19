<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Infrastructure\Storage;

use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Ordering\Contract\Storage\CartStorageContract;
use Recode\Ecommerce\Core\Shared\Collection\ArrayCollection;
use Recode\Ecommerce\Core\Shared\Contract\Collection;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

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
