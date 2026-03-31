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

use InvalidArgumentException;
use LimitIterator;
use OutOfBoundsException;

/**
 * Class LookaheadIterator.
 *
 * An iterator that allows peeking at the next value(s) and stepping back to the previous value(s)
 * without advancing the iteration.
 *
 * This iterator extends `IteratorIterator` and provides methods `peek()` and `prev()`
 * to inspect the next and previous values **without modifying** the current iteration state.
 *
 * ## Usage Example:
 *
 * @example Using LookaheadIterator
 * ```php
 * use FastForward\Iterator\LookaheadIterator;
 * use ArrayIterator;
 *
 * $data = new ArrayIterator(['A', 'B', 'C', 'D']);
 * $lookaheadIterator = new LookaheadIterator($data);
 *
 * foreach ($lookaheadIterator as $value) {
 *     echo "Current: " . var_export($value, true) . " | Next: " . var_export($lookaheadIterator->peek(), true) . " | Prev: " . var_export($lookaheadIterator->prev(), true) . "\n";
 * }
 * // Outputs:
 * // Current: 'A' | Next: 'B' | Prev: null
 * // Current: 'B' | Next: 'C' | Prev: 'A'
 * // Current: 'C' | Next: 'D' | Prev: 'B'
 * // Current: 'D' | Next: null | Prev: 'C'
 * ```
 *
 * @since 1.1.0
 */
class LookaheadIterator extends CountableIteratorIterator
{
    /**
     * @var int the current iterator position
     */
    private int $position = 0;

    /**
     * @var LimitIterator A separate instance of the iterator used for peeking.
     *
     * This iterator ensures that calling `lookAhead()` and `lookBehind()` does not affect the main iterator's position.
     */
    private readonly LimitIterator $peekableInnerIterator;

    /**
     * Initializes the LookaheadIterator.
     *
     * @param iterable $iterator the iterator to wrap
     */
    public function __construct(iterable $iterator)
    {
        parent::__construct(new IterableIterator($iterator));
        $this->peekableInnerIterator = new LimitIterator(self::getInnerIterator());
    }

    /**
     * Retrieves the next value(s) without advancing the iterator.
     *
     * If `$count` is specified, an array of the next `$count` values will be returned.
     *
     * @param int $count the number of upcoming values to peek at (default: 1)
     *
     * @return mixed the next value, an array of upcoming values, or `null` if no further elements exist
     *
     * @throws InvalidArgumentException if `$count` is less than 1
     */
    public function lookAhead(int $count = 1): mixed
    {
        if ($count < 1) {
            throw new InvalidArgumentException('Peek count must be at least 1.');
        }

        try {
            $peekIterator = new LimitIterator($this->peekableInnerIterator, $this->position + 1, $count);
            $result       = iterator_to_array($peekIterator, false);

            // Reset the peek iterator to avoid side effects
            $this->peekableInnerIterator->seek($this->position);
        } catch (OutOfBoundsException) {
            return null;
        }

        return 1 === $count || [] === $result ? ($result[0] ?? null) : $result;
    }

    /**
     * Retrieves the previous value(s) without moving the iterator backward.
     *
     * If `$count` is specified, an array of the previous `$count` values will be returned.
     *
     * @param int $count the number of previous values to retrieve (default: 1)
     *
     * @return mixed the previous value, an array of previous values, or `null` if no previous elements exist
     *
     * @throws InvalidArgumentException if `$count` is less than 1
     */
    public function lookBehind(int $count = 1): mixed
    {
        if ($count < 1) {
            throw new InvalidArgumentException('Prev count must be at least 1.');
        }

        // Ensure we don't try to look back more than we've seen.
        $lookBehind = min($count, $this->position);

        if ($this->position - $lookBehind < 0) {
            return null;
        }

        try {
            // Get from the caching iterator, which maintains a history of seen elements.
            $prevIterator = new LimitIterator($this->peekableInnerIterator, max(
                0,
                $this->position - $count
            ), $lookBehind);
            $result       = iterator_to_array($prevIterator, false);

            // Reset the peek iterator to avoid side effects
            $this->peekableInnerIterator->seek($this->position);
        } catch (OutOfBoundsException) {
            return null;
        }

        return 1 === $count ? ($result[0] ?? null) : $result;
    }

    /**
     * Advances the iterator and updates the internal position counter.
     *
     * This method increments the internal position tracker and moves the iterator forward.
     *
     * @return void
     */
    public function next(): void
    {
        parent::next();
        ++$this->position;
    }

    /**
     * Resets the iterator to the first available element.
     *
     * This method rewinds both the main iterator and the peeking iterator,
     * ensuring that both are in sync when restarting the iteration.
     *
     * @return void
     */
    public function rewind(): void
    {
        parent::rewind();
        $this->position = 0;
    }
}
