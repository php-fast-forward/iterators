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

/**
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
 * @example Iterating Over a Floating-Point Range Including the Boundary
 * ```php
 * use FastForward\Iterator\RangeIterator;
 *
 * $iterator = new RangeIterator(0, 5, 1.5, true);
 *
 * foreach ($iterator as $value) {
 *     echo $value . "\n";
 * }
 * // Output:
 * // 0
 * // 1.5
 * // 3.0
 * // 4.5
 * // 5.0
 * ```
 *
 * **Note:** If the `step` is larger than the absolute difference between `start` and `end`,
 * an `InvalidArgumentException` is thrown.
 *
 * @since 1.0.0
 */

namespace FastForward\Iterator;

use Iterator;
use Countable;
use InvalidArgumentException;

class RangeIterator implements Iterator, Countable
{
    /**
     * @var float floating-point comparison tolerance
     */
    private const float EPSILON = 1.0E-12;

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
    private readonly float|int $step;

    /**
     * @var bool indicates whether the iterator should force the boundary value when the next step would overshoot the range
     */
    private bool $boundaryYielded = false;

    /**
     * Initializes the RangeIterator.
     *
     * @param float|int $start the starting value of the range
     * @param float|int $end the ending value of the range
     * @param float|int $step the step size between values (must be positive)
     * @param bool $includeBoundary whether the iterator should force the end value when the next step would overshoot it
     *
     * @throws InvalidArgumentException if step is non-positive or greater than the range size
     */
    public function __construct(
        private readonly float|int $start,
        private readonly float|int $end,
        float|int $step = 1,
        private readonly bool $includeBoundary = false
    ) {
        if ($step <= 0) {
            throw new InvalidArgumentException('Step must be a positive integer or float.');
        }

        $rangeSize = abs($this->end - $this->start);

        if ($rangeSize > 0 && $step > $rangeSize) {
            throw new InvalidArgumentException(
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
     *
     * @return void
     */
    public function next(): void
    {
        $projected = $this->current + $this->step;

        if (
            $this->includeBoundary
            && ! $this->boundaryYielded
            && ! $this->isAtBoundary($this->current)
            && $this->wouldOvershoot($projected)
        ) {
            $this->current = $this->end;
            $this->boundaryYielded = true;
            ++$this->key;

            return;
        }

        $this->current = $projected;
        ++$this->key;
    }

    /**
     * Resets the iterator to the start of the range.
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->boundaryYielded = false;
        $this->current = $this->start;
        $this->key = 0;
    }

    /**
     * Checks if the current position is within the valid range.
     *
     * @return bool true if the current value is within the valid range, false otherwise
     */
    public function valid(): bool
    {
        return $this->step > 0
            ? $this->current <= $this->end + self::EPSILON
            : $this->current >= $this->end - self::EPSILON;
    }

    /**
     * Counts the total number of steps in the range.
     *
     * @return int the number of elements in the range
     */
    public function count(): int
    {
        $length = abs($this->end - $this->start);

        if ($length <= self::EPSILON) {
            return 1;
        }

        $step = abs($this->step);
        $quotient = $length / $step;
        $wholeSteps = (int) floor($quotient + self::EPSILON);
        $count = $wholeSteps + 1;
        $hasRemainder = abs($quotient - $wholeSteps) > self::EPSILON;

        if ($this->includeBoundary && $hasRemainder) {
            ++$count;
        }

        return $count;
    }

    /**
     * Checks whether the given value is effectively equal to the range boundary.
     *
     * This method accounts for floating-point precision issues by using a tolerance value (EPSILON)
     * to determine if the current value is close enough to the end value to be considered at the boundary.
     *
     * @param float|int $value the value to check against the boundary
     *
     * @return bool true if the value is effectively at the boundary, false otherwise
     */
    private function isAtBoundary(float|int $value): bool
    {
        return abs($value - $this->end) <= self::EPSILON;
    }

    /**
     * Checks whether the projected next value would exceed the range boundary.
     *
     * This method is used to determine if the next step would overshoot the end value,
     * which is important when the `includeBoundary` option is enabled to ensure thatthe boundary value is yielded when appropriate.
     *
     * @param float|int $projected the next value after applying the step
     *
     * @return bool true if the projected value would overshoot the end boundary, false otherwise
     */
    private function wouldOvershoot(float|int $projected): bool
    {
        return $this->step > 0
            ? $projected > $this->end + self::EPSILON
            : $projected < $this->end - self::EPSILON;
    }
}
