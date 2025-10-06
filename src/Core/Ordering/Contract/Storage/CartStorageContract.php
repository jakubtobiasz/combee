<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\Storage;

use Combee\Core\Ordering\Contract\Model\OrderContract;
use Ramsey\Uuid\UuidInterface;

interface CartStorageContract
{
    public function get(UuidInterface $cartUuid): ?OrderContract;

    public function save(OrderContract $cart): void;
}
