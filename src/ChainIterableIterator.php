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
 * Class ChainIterableIterator.
 *
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
 * @package FastForward\Iterator
 *
 * @since 1.1.0
 */
final class ChainIterableIterator implements \Iterator
{
    /**
     * @var \Iterator[] a list of iterators chained in sequence
     */
    private array $iterators;

    /**
     * @var int the index of the currently active iterator
     */
    private int $currentIndex = 0;

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
            static fn (iterable $iterable) => new IterableIterator($iterable),
            $iterables
        );
    }

    /**
     * Rewinds all underlying iterators and resets the position.
     *
     * Each chained iterator SHALL be rewound to its beginning.
     */
    public function rewind(): void
    {
        foreach ($this->iterators as $iterable) {
            $iterable->rewind();
        }

        $this->currentIndex = 0;
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
        while (isset($this->iterators[$this->currentIndex])) {
            if ($this->iterators[$this->currentIndex]->valid()) {
                return true;
            }
            ++$this->currentIndex;
        }

        return false;
    }

    /**
     * Returns the current element from the active iterator.
     *
     * @return null|mixed the current element or NULL if iteration is invalid
     */
    public function current(): mixed
    {
        if (!$this->valid()) {
            return null;
        }

        return $this->iterators[$this->currentIndex]->current();
    }

    /**
     * Returns the current key from the active iterator.
     *
     * @return null|mixed the current key or NULL if iteration is invalid
     */
    public function key(): mixed
    {
        if (!$this->valid()) {
            return null;
        }

        return $this->iterators[$this->currentIndex]->key();
    }

    /**
     * Moves the pointer of the active iterator forward.
     */
    public function next(): void
    {
        if (!$this->valid()) {
            return;
        }

        $this->iterators[$this->currentIndex]->next();
    }
}
