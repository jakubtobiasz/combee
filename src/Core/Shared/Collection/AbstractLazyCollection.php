<?php declare(strict_types=1);

namespace Combee\Core\Shared\Collection;

use Combee\Core\Shared\Contract\Collection;
use Doctrine\Common\Collections\AbstractLazyCollection as DoctrineAbstractLazyCollection;

/**
 * Lazy collection that is backed by a concrete collection
 *
 * @phpstan-template TKey of array-key
 * @phpstan-template T
 * @template-extends DoctrineAbstractLazyCollection<TKey,T>
 * @template-implements Collection<TKey,T>
 */
abstract class AbstractLazyCollection extends DoctrineAbstractLazyCollection implements Collection
{
}
