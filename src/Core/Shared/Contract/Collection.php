<?php declare(strict_types=1);

namespace Combee\Core\Shared\Contract;

use Doctrine\Common\Collections\Collection as DoctrineCollection;

/**
 * @phpstan-template TKey of array-key
 * @phpstan-template T
 *
 * @template-extends DoctrineCollection<TKey, T>
 */
interface Collection extends DoctrineCollection
{
}
