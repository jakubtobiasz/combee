<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Storage;

use Combee\Core\Ordering\Contract\Model\OrderContract;
use Combee\Core\Shared\Model\Identifier\OrderIdentifier;

interface CartStorageContract
{
    public function findByIdentifier(OrderIdentifier $identifier): ?OrderContract;

    public function store(OrderContract $cart): void;
}
