<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/iterators.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/php-fast-forward/iterators
 * @copyright Copyright (c) 2025 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace FastForward\Iterator;

/**
 * Class RangeIterator.
 *
 * An iterator that behaves like PHP's `range()` function.
 * It supports both ascending and descending sequences and allows iteration
 * over floating-point or integer ranges.
 *
 * ## Usage Example:
 *
 * @example Iterating Over an Integer Range
 * ```php
 * use FastForward\Iterator\RangeIterator;
 *
 * $iterator = new RangeIterator(1, 10, 2);
 *
 * foreach ($iterator as $key => $value) {
 *     echo "[$key] => $value\n";
 * }
 * // Output:
 * // [0] => 1
 * // [1] => 3
 * // [2] => 5
 * // [3] => 7
 * // [4] => 9
 * ```
 * @example Iterating Over a Floating-Point Range
 * ```php
 * use FastForward\Iterator\RangeIterator;
 *
 * $iterator = new RangeIterator(0.5, 2.5, 0.5);
 *
 * foreach ($iterator as $value) {
 *     echo $value . "\n";
 * }
 * // Output:
 * // 0.5
 * // 1.0
 * // 1.5
 * // 2.0
 * // 2.5
 * ```
 *
 * **Note:** If the `step` is larger than the absolute difference between `start` and `end`,
 * an `InvalidArgumentException` is thrown.
 *
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class RangeIterator implements \Iterator, \Countable
{
    /**
     * @var int the current key (index) in the iteration
     */
    private int $key = 0;

    /**
     * @var float|int the current value in the iteration
     */
    private float|int $current;

    /**
     * @var float|int the step size for each iteration
     */
    private float|int $step;

    /**
     * Initializes the RangeIterator.
     *
     * @param float|int $start the starting value of the range
     * @param float|int $end   the ending value of the range
     * @param float|int $step  the step size between values (must be positive)
     *
     * @throws \InvalidArgumentException if step is non-positive or greater than the range size
     */
    public function __construct(
        private float|int $start,
        private float|int $end,
        float|int $step = 1
    ) {
        if ($step <= 0) {
            throw new \InvalidArgumentException('Step must be a positive integer or float.');
        }

        $rangeSize = abs($this->end - $this->start);

        if ($step > $rangeSize) {
            throw new \InvalidArgumentException(
                'Step cannot be greater than the absolute difference between start and end.'
            );
        }

        $this->step    = ($start > $end) ? -$step : $step;
        $this->current = $start;
    }

    /**
     * Returns the current value in the range.
     *
     * @return float|int the current value
     */
    public function current(): float|int
    {
        return $this->current;
    }

    /**
     * Returns the current key (index).
     *
     * @return int the current index in the iteration
     */
    public function key(): int
    {
        return $this->key;
    }

    /**
     * Moves to the next value in the range.
     */
    public function next(): void
    {
        $this->current += $this->step;
        ++$this->key;
    }

    /**
     * Resets the iterator to the start of the range.
     */
    public function rewind(): void
    {
        $this->current = $this->start;
        $this->key     = 0;
    }

    /**
     * Checks if the current position is within the valid range.
     *
     * @return bool true if the current value is within the valid range, false otherwise
     */
    public function valid(): bool
    {
        return ($this->step > 0) ? $this->current <= $this->end : $this->current >= $this->end;
    }

    /**
     * Counts the total number of steps in the range.
     *
     * @return int the number of elements in the range
     */
    public function count(): int
    {
        if (($this->step > 0 && $this->end < $this->start)
            || ($this->step < 0 && $this->end > $this->start)) {
            return 0;
        }

        return intdiv(abs($this->end - $this->start), abs($this->step)) + 1;
    }
}
