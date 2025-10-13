<?php declare(strict_types=1);

namespace Combee\Core\Shared\Collection;

use Combee\Core\Shared\Contract\Collection;
use Doctrine\Common\Collections\ArrayCollection as DoctrineArrayCollection;

/**
 * @phpstan-template TKey of array-key
 * @phpstan-template T
 * @template-extends DoctrineArrayCollection<TKey,T>
 * @template-implements Collection<TKey,T>
 * @phpstan-consistent-constructor
 */
class ArrayCollection extends DoctrineArrayCollection implements Collection
{
}
