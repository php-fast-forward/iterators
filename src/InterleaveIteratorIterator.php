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

use Iterator;
use InvalidArgumentException;

/**
 * Interleaves elements from multiple iterators in a round-robin fashion.
 *
 * This iterator alternates between multiple traversable sources,
 * returning one element from each before cycling back to the first.
 * The iteration stops once all iterators are exhausted.
 *
 * ## Usage Example:
 *
 * @example Interleaving two iterators
 * ```php
 * use FastForward\Iterator\InterleaveIteratorIterator;
 * use ArrayIterator;
 *
 * $dataSetOne = new ArrayIterator([1, 3, 5]);
 * $dataSetTwo = new ArrayIterator([2, 4, 6]);
 *
 * $interleavedIterator = new InterleaveIteratorIterator($dataSetOne, $dataSetTwo);
 *
 * foreach ($interleavedIterator as $value) {
 *     echo $value . ' '; // Outputs: 1 2 3 4 5 6
 * }
 * ```
 *
 * **Note:** The iterator stops once all sources are exhausted.
 *
 * @since 1.0.0
 */
class InterleaveIteratorIterator extends CountableIterator
{
    /**
     * @var array<int, Iterator> list of active iterators
     */
    private array $iterators;

    /**
     * @var int the current iterator index
     */
    private int $currentIndex = 0;

    /**
     * @var int the normalized sequential numeric key for yielded values without string keys
     */
    private int $position = 0;

    /**
     * Initializes the InterleaveIteratorIterator.
     *
     * @param iterable ...$iterators The iterators to be interleaved.
     *
     * @throws InvalidArgumentException if no iterators are provided
     */
    public function __construct(iterable ...$iterators)
    {
        if ([] === $iterators) {
            throw new InvalidArgumentException('At least one iterator must be provided.');
        }

        $this->iterators = array_map(
            static fn(iterable $iterator): Iterator => new IterableIterator($iterator),
            $iterators
        );

        // Inicializa os iteradores
        foreach ($this->iterators as $iterator) {
            $iterator->rewind();
        }
    }

    /**
     * Retrieves the current element from the active iterator.
     *
     * @return mixed the current element
     */
    public function current(): mixed
    {
        return $this->iterators[$this->currentIndex]->current();
    }

    /**
     * Retrieves the current key from the active iterator or a normalized sequential key.
     *
     * If the active iterator's current key is a string, it is returned directly.
     * Otherwise, a normalized sequential numeric key is returned based on the position of yielded values without string keys.
     *
     * @return string|int the current key
     */
    public function key(): string|int
    {
        $iteratorKey = $this->iterators[$this->currentIndex]->key();

        if (\is_string($iteratorKey)) {
            return $iteratorKey;
        }

        return $this->position;
    }

    /**
     * @return void
     */
    public function next(): void
    {
        $currentKey = $this->iterators[$this->currentIndex]->key();

        $this->iterators[$this->currentIndex]->next();

        if (! \is_string($currentKey)) {
            ++$this->position;
        }

        if (! $this->valid()) {
            return;
        }

        do {
            $this->currentIndex = ($this->currentIndex + 1) % \count($this->iterators);
        } while (! $this->iterators[$this->currentIndex]->valid() && $this->valid());
    }

    /**
     * Checks if at least one iterator still has elements.
     *
     * @return bool true if there are remaining elements, false otherwise
     */
    public function valid(): bool
    {
        foreach ($this->iterators as $iterator) {
            if ($iterator->valid()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->currentIndex = 0;
        $this->position = 0;

        foreach ($this->iterators as $iterator) {
            $iterator->rewind();
        }

        if (! $this->valid()) {
            return;
        }

        while (! $this->iterators[$this->currentIndex]->valid()) {
            $this->currentIndex = ($this->currentIndex + 1) % \count($this->iterators);
        }
    }
}
