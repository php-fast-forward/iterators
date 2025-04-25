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
 * Class ZipIteratorIterator.
 *
 * Combines multiple iterators into a single iterator, returning arrays of grouped values.
 *
 * This iterator synchronously iterates over multiple traversable sources,
 * yielding an array where each element corresponds to the current value of each source.
 * The iteration stops when the **shortest** iterator is exhausted.
 *
 * ## Usage Example:
 *
 * @example Zipping two iterators
 * ```php
 * use FastForward\Iterator\ZipIteratorIterator;
 * use ArrayIterator;
 *
 * $dataSetOne = new ArrayIterator([1, 2, 3]);
 * $dataSetTwo = new ArrayIterator(['A', 'B', 'C']);
 *
 * $zippedIterator = new ZipIteratorIterator($dataSetOne, $dataSetTwo);
 *
 * foreach ($zippedIterator as $pair) {
 *     print_r($pair);
 * }
 * // Outputs:
 * // [1, 'A']
 * // [2, 'B']
 * // [3, 'C']
 * ```
 *
 * **Note:** The iterator stops when the shortest iterable is exhausted.
 *
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class ZipIteratorIterator implements \Iterator
{
    /**
     * @var array<int, \Iterator> the list of active iterators
     */
    private array $iterators;

    /**
     * @var int the current iteration index
     */
    private int $currentIndex = 0;

    /**
     * Initializes the ZipIteratorIterator.
     *
     * @param iterable ...$iterators The iterators to be combined.
     *
     * @throws \InvalidArgumentException if fewer than two iterators are provided
     */
    public function __construct(iterable ...$iterators)
    {
        if (\count($iterators) < 2) {
            throw new \InvalidArgumentException('At least two iterators are required.');
        }

        $this->iterators = array_map(
            static fn (\Traversable $iterator): \Iterator => new IterableIterator($iterator),
            $iterators
        );

        // Inicializa os iteradores
        foreach ($this->iterators as $iterator) {
            $iterator->rewind();
        }
    }

    /**
     * Retrieves the current set of values from each iterator.
     *
     * @return array<int, mixed> the array of current values from each iterator
     */
    public function current(): array
    {
        return array_map(static fn (\Iterator $iterator) => $iterator->current(), $this->iterators);
    }

    /**
     * Retrieves the current key (index) of the iteration.
     *
     * @return int the current index
     */
    public function key(): int
    {
        return $this->currentIndex;
    }

    /**
     * Moves to the next set of values in each iterator.
     */
    public function next(): void
    {
        foreach ($this->iterators as $iterator) {
            $iterator->next();
        }
        ++$this->currentIndex;
    }

    /**
     * Checks if all iterators still have valid elements.
     *
     * The iteration stops when the shortest iterator is exhausted.
     *
     * @return bool true if valid elements exist, false otherwise
     */
    public function valid(): bool
    {
        foreach ($this->iterators as $iterator) {
            if (!$iterator->valid()) {
                return false;
            }
        }

        return true;
    }

    /**
     * Resets the iterator to the beginning.
     */
    public function rewind(): void
    {
        $this->currentIndex = 0;

        foreach ($this->iterators as $iterator) {
            $iterator->rewind();
        }
    }
}
