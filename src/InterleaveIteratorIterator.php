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
 * Class InterleaveIteratorIterator.
 *
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
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class InterleaveIteratorIterator implements \Iterator
{
    /**
     * @var array<int, \Iterator> list of active iterators
     */
    private array $iterators;

    /**
     * @var int the current iterator index
     */
    private int $currentIndex = 0;

    /**
     * Initializes the InterleaveIteratorIterator.
     *
     * @param \Traversable ...$iterators The iterators to be interleaved.
     *
     * @throws \InvalidArgumentException if no iterators are provided
     */
    public function __construct(\Traversable ...$iterators)
    {
        if (0 === \count($iterators)) {
            throw new \InvalidArgumentException('At least one iterator must be provided.');
        }

        $this->iterators = array_map(
            static fn (\Traversable $iterator): \Iterator => $iterator instanceof \Iterator ? $iterator : new \IteratorIterator($iterator),
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
     * Retrieves the current iterator index.
     *
     * @return int the index of the active iterator
     */
    public function key(): int
    {
        return $this->currentIndex;
    }

    /**
     * Advances to the next element in a round-robin fashion.
     */
    public function next(): void
    {
        $this->iterators[$this->currentIndex]->next();

        do {
            $this->currentIndex = ($this->currentIndex + 1) % \count($this->iterators);
        } while (!$this->iterators[$this->currentIndex]->valid() && $this->valid());
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
     * Resets the iterator to the first available element.
     */
    public function rewind(): void
    {
        $this->currentIndex = 0;
        foreach ($this->iterators as $iterator) {
            $iterator->rewind();
        }
    }
}
