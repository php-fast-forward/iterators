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
 * Class SlidingWindowIteratorIterator.
 *
 * Provides a sliding window over an iterator with sequential keys.
 *
 * This iterator returns overlapping windows of elements with keys
 * starting from `0` and incrementing sequentially.
 *
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class SlidingWindowIteratorIterator extends \IteratorIterator
{
    /**
     * @var int the fixed size of each sliding window
     */
    private int $windowSize;

    /**
     * @var array<int, mixed> the buffer holding the current window of elements
     */
    private array $window = [];

    /**
     * @var int the current sequential key for the iterator
     */
    private int $key = 0;

    /**
     * Initializes the SlidingWindowIteratorIterator.
     *
     * @param \Traversable $iterator   the iterator containing values
     * @param int          $windowSize the number of elements per window (must be >= 1)
     *
     * @throws \InvalidArgumentException if $windowSize is less than 1
     */
    public function __construct(\Traversable $iterator, int $windowSize)
    {
        if ($windowSize < 1) {
            throw new \InvalidArgumentException('Window size must be at least 1.');
        }

        parent::__construct($iterator);
        $this->windowSize = $windowSize;
    }

    /**
     * Advances to the next element, maintaining the sliding window.
     */
    public function next(): void
    {
        array_shift($this->window);
        parent::next();
        ++$this->key;
    }

    /**
     * Retrieves the current sliding window of elements.
     *
     * @return array<int, mixed> the current window of elements
     */
    public function current(): array
    {
        return $this->window;
    }

    /**
     * Returns the current sequential key.
     *
     * @return int the current key, starting from 0
     */
    public function key(): int
    {
        return $this->key;
    }

    /**
     * Determines whether the current window is valid.
     *
     * The iterator continues filling the window until the required size is met.
     * If fewer elements than the window size exist, iteration stops.
     *
     * @return bool true if a valid window exists, false otherwise
     */
    public function valid(): bool
    {
        while (parent::valid() && \count($this->window) < $this->windowSize) {
            $this->window[] = parent::current();
            parent::next();
        }

        return \count($this->window) === $this->windowSize;
    }

    /**
     * Resets the iterator, allowing re-iteration.
     */
    public function rewind(): void
    {
        parent::rewind();
        $this->window = [];
        $this->key    = 0;
    }
}
