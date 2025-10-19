<?php declare(strict_types=1);

namespace Recode\Ecommerce\Core\Ordering\Contract\Storage;

use Recode\Ecommerce\Core\Ordering\Contract\Model\OrderContract;
use Recode\Ecommerce\Core\Shared\Model\Identifier\OrderIdentifier;

interface CartStorageContract
{
    public function findByIdentifier(OrderIdentifier $identifier): ?OrderContract;

    public function store(OrderContract $cart): void;
}
