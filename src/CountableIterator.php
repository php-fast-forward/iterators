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

use Countable;
use Iterator;

/**
 * Provides a base iterator implementation that is also countable.
 *
 * This abstract class SHALL be used as a foundation for iterators that need
 * to expose counting behavior while remaining compatible with the standard
 * {@see Iterator} contract. Implementations MUST preserve iterator semantics,
 * and consumers SHOULD expect the counting logic to operate over the same
 * sequence that is exposed during normal iteration.
 */
abstract class CountableIterator implements Iterator, Countable
{
    /**
     * Counts the number of elements available in the iterator.
     *
     * This method MUST count the elements by iterating over a clone of the
     * current iterator instance so that the active iterator state of the
     * original object is not modified during the counting process. Concrete
     * implementations SHOULD therefore remain safely cloneable whenever this
     * behavior is expected to be used.
     *
     * @return int the total number of elements exposed by the iterator
     */
    public function count(): int
    {
        return iterator_count(clone $this);
    }
}
