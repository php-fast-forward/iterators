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

use LimitIterator;
use Countable;
use InfiniteIterator;

/**
 * Class RepeatableIteratorIterator.
 *
 * An iterator that enables repeated iteration over a finite subset of an infinite iterator.
 *
 * This iterator wraps an `Iterator` and applies a `LimitIterator` over an `InfiniteIterator`,
 * allowing a limited number of repeated iterations without modifying the underlying iterator.
 *
 * It also implements `Countable` to return the number of elements available in the limited iteration.
 *
 * ## Usage Example:
 *
 * @example Limiting an Infinite Iterator
 * ```php
 * use FastForward\Iterator\RepeatableIteratorIterator;
 * use ArrayIterator;
 *
 * $data = new ArrayIterator([1, 2, 3, 4, 5]);
 * $repeatableIterator = new RepeatableIteratorIterator($data, 3);
 *
 * echo count($repeatableIterator); // Outputs: 3
 *
 * foreach ($repeatableIterator as $value) {
 *     echo $value . ' '; // Outputs: 1 2 3
 * }
 * ```
 *
 * **Note:** The iterator **does not consume** values permanently,
 * as it is backed by an `InfiniteIterator` and `LimitIterator`.
 *
 * @since 1.0.0
 */
class RepeatableIteratorIterator extends LimitIterator implements Countable
{
    /**
     * Initializes the RepeatableIteratorIterator.
     *
     * @param iterable $iterator the iterator to be wrapped in an infinite loop
     * @param int $limit the maximum number of elements to iterate over per cycle
     * @param int $offset the starting offset within the iterator
     */
    public function __construct(
        iterable $iterator,
        private readonly int $limit,
        int $offset = 0
    ) {
        parent::__construct(new InfiniteIterator(new IterableIterator($iterator)), $offset, $this->limit);
    }

    /**
     * Returns the number of elements that can be iterated per cycle.
     *
     * @return int the count of items in the limited iteration
     */
    public function count(): int
    {
        return $this->limit;
    }
}
