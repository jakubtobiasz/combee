<?php declare(strict_types=1);

namespace Combee\Core\Ordering\Contract\DataObject;

interface ProductData
{
    public string $sku { get; }

    public string $name { get; }
}