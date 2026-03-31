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
 * An iterator that chains multiple iterable sources together into a single unified iterator.
 *
 * This iterator SHALL accept any number of iterable values (arrays, Traversables, or Iterators)
 * and iterate over them in order. When the current iterator is exhausted, it proceeds to the next.
 *
 * The class MUST ensure all incoming values are wrapped as \Iterator instances, either natively
 * or by converting Traversables or arrays using standard SPL iterators.
 *
 * Example usage:
 *
 * ```php
 * $it = new ChainIterableIterator([1, 2], new ArrayIterator([3, 4]));
 * foreach ($it as $value) {
 *     echo $value;
 * }
 * // Output: 1234
 * ```
 *
 * @since 1.1.0
 */
final class ChainIterableIterator implements Iterator, Countable
{
    /**
     * @var Iterator[] a list of iterators chained in sequence
     */
    private array $iterators;

    /**
     * @var int the index of the currently active iterator
     */
    private int $currentIndex = 0;

    /**
     * @var int the normalized sequential key across all chained iterators
     */
    private int $position = 0;

    /**
     * Constructs a ChainIterableIterator with one or more iterable sources.
     *
     * Each iterable SHALL be normalized to a \Iterator instance using:
     * - \ArrayIterator for arrays
     * - \IteratorIterator for Traversable objects
     * - Directly used if already an \Iterator
     *
     * @param iterable ...$iterables One or more iterable data sources to chain.
     */
    public function __construct(iterable ...$iterables)
    {
        $this->iterators = array_map(
            static fn(iterable $iterable): IterableIterator => new IterableIterator($iterable),
            $iterables
        );
    }

    /**
     * Counts the total number of elements across all chained iterators.
     *
     * This method iterates through each underlying iterator and sums their counts.
     *
     * @return int the total count of elements in all chained iterators
     */
    public function count(): int
    {
        return array_reduce(
            $this->iterators,
            static fn(int $carry, IterableIterator $iterator): int => $carry + $iterator->count(),
            0
        );
    }

    /**
     * Rewinds all underlying iterators and resets the position.
     *
     * Each chained iterator SHALL be rewound to its beginning.
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->currentIndex = 0;
        $this->position = 0;
        foreach ($this->iterators as $iterable) {
            $iterable->rewind();
        }

        // Após o rewind, reposiciona no primeiro iterador válido
        while (
            isset($this->iterators[$this->currentIndex])
            && ! $this->iterators[$this->currentIndex]->valid()
        ) {
            ++$this->currentIndex;
        }
    }

    /**
     * Checks whether the current position is valid across chained iterators.
     *
     * Iteration continues until the current iterator is valid or all are exhausted.
     *
     * @return bool TRUE if there are more elements to iterate; FALSE otherwise
     */
    public function valid(): bool
    {
        if (! isset($this->iterators[$this->currentIndex])) {
            return false;
        }

        return $this->iterators[$this->currentIndex]->valid();
    }

    /**
     * Returns the current element from the active iterator.
     *
     * @return mixed|null the current element or NULL if iteration is invalid
     */
    public function current(): mixed
    {
        if (! $this->valid()) {
            return null;
        }

        return $this->iterators[$this->currentIndex]->current();
    }

    /**
     * @return int|null
     */
    public function key(): ?int
    {
        if (! $this->valid()) {
            return null;
        }

        return $this->position;
    }

    /**
     * Moves the pointer of the active iterator forward.
     *
     * @return void
     */
    public function next(): void
    {
        if (! isset($this->iterators[$this->currentIndex])) {
            return;
        }

        $this->iterators[$this->currentIndex]->next();

        while (
            isset($this->iterators[$this->currentIndex])
            && ! $this->iterators[$this->currentIndex]->valid()
        ) {
            ++$this->currentIndex;
        }

        if ($this->valid()) {
            ++$this->position;
        }
    }
}
