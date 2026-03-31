<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/iterators.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @copyright Copyright (c) 2025-2026 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 *
 * @see       https://github.com/php-fast-forward/iterators
 * @see       https://github.com/php-fast-forward
 * @see       https://datatracker.ietf.org/doc/html/rfc2119
 */

namespace FastForward\Iterator;

use ReflectionClass;
use Countable;
use IteratorIterator;

/**
 * Provides counting behavior for iterators and iterator aggregates.
 *
 * This trait SHALL add a {@see count()} implementation that delegates to the
 * inner iterator when possible. When the inner iterator does not implement
 * {@see Countable}, the trait MUST determine whether the iterator can be safely
 * cloned before counting its elements through traversal. Implementing classes
 * MUST provide a compatible {@see getInnerIterator()} method that returns the
 * traversable object to be counted.
 */
trait CountableIteratorIteratorTrait
{
    /**
     * Counts the number of elements exposed by the inner iterator.
     *
     * If the inner iterator implements {@see Countable}, this method SHALL
     * return the value provided by that implementation. Otherwise, it MUST count
     * elements by iterating over the iterator. If the inner iterator is not
     * cloneable, this method SHALL wrap the current object in an
     * {@see IteratorIterator} instance and count through that wrapper to avoid
     * performing an invalid clone operation. If the inner iterator is cloneable,
     * this method SHOULD count over a clone so that the original iterator state
     * is preserved as much as possible.
     *
     * @return int the total number of elements available from the inner iterator
     */
    public function count(): int
    {
        $inner = $this->getInnerIterator();

        if ($inner instanceof Countable) {
            return $inner->count();
        }

        $isCloneable = (new ReflectionClass($inner))->isCloneable();

        if (! $isCloneable) {
            return iterator_count(new IteratorIterator($this));
        }

        return iterator_count(clone $inner);
    }
}
