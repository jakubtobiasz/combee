<?php declare(strict_types=1);

namespace Combee\Core\Model\Identifier;

use Symfony\Component\Uid\UuidV7;

abstract class AbstractIdentifier extends UuidV7
{
    public static function new(): static
    {
        /** @phpstan-ignore new.static */
        return new static();
    }
}
