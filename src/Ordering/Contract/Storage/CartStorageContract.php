<?php declare(strict_types=1);

namespace Combee\Ordering\Contract\Storage;

use Combee\Core\Model\Identifier\OrderIdentifier;
use Combee\Ordering\Contract\Model\OrderContract;

interface CartStorageContract
{
    public function get(OrderIdentifier $cartUuid): ?OrderContract;

    public function save(OrderContract $cart): void;
}
