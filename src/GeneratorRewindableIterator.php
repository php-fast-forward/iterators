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
 * Class GeneratorRewindableIterator.
 *
 * An iterator that allows rewinding over a generator by caching its values.
 *
 * This class wraps a generator or a closure returning a generator, enabling
 * multiple iterations over the generated sequence by caching its results.
 *
 * ## Usage Example:
 *
 * @example Using a Generator
 * ```php
 * use FastForward\Iterator\GeneratorRewindableIterator;
 *
 * $iterator = new GeneratorRewindableIterator(
 *     (function () {
 *         yield 'A';
 *         yield 'B';
 *         yield 'C';
 *     })()
 * );
 *
 * foreach ($iterator as $value) {
 *     echo $value; // Outputs: A B C
 * }
 *
 * foreach ($iterator as $value) {
 *     echo $value; // Outputs: A B C (rewound)
 * }
 * ```
 * @example Using a Callable that Returns a Generator
 * ```php
 * use FastForward\Iterator\GeneratorRewindableIterator;
 *
 * $iterator = new GeneratorRewindableIterator(fn () => (function () {
 *     yield 1;
 *     yield 2;
 *     yield 3;
 * })());
 *
 * foreach ($iterator as $value) {
 *     echo $value; // Outputs: 1 2 3
 * }
 *
 * foreach ($iterator as $value) {
 *     echo $value; // Outputs: 1 2 3 (rewound)
 * }
 * ```
 *
 * **Note:** This implementation ensures that the generator can be rewound
 * by caching its results using `GeneratorCachingIteratorAggregate`.
 *
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class GeneratorRewindableIterator implements \Iterator
{
    /**
     * @var \IteratorAggregate the iterator aggregate that caches generated values
     */
    private \IteratorAggregate $iteratorAggregate;

    /**
     * @var \IteratorIterator the internal innerIterator iterator used for iteration
     */
    private \IteratorIterator $innerIterator;

    /**
     * Initializes the GeneratorRewindableIterator with a generator or a closure returning a generator.
     *
     * @param \Closure|\Generator $generator a generator instance or a callable that returns a generator
     */
    public function __construct(private \Closure|\Generator $generator)
    {
        $this->iteratorAggregate = new GeneratorCachingIteratorAggregate($this->generator);
    }

    /**
     * Rewinds the iterator to the beginning.
     *
     * This method creates a new `IteratorIterator` instance wrapping the
     * `GeneratorCachingIteratorAggregate`, ensuring that the generator can be reused.
     */
    public function rewind(): void
    {
        $this->innerIterator = new \IteratorIterator($this->iteratorAggregate->getIterator());
        $this->innerIterator->rewind();
    }

    /**
     * Retrieves the current element from the iterator.
     *
     * @return mixed the current element
     */
    public function current(): mixed
    {
        return $this->innerIterator->current();
    }

    /**
     * Retrieves the key of the current element.
     *
     * @return mixed the key associated with the current element
     */
    public function key(): mixed
    {
        return $this->innerIterator->key();
    }

    /**
     * Advances the iterator to the next element.
     */
    public function next(): void
    {
        $this->innerIterator->next();
    }

    /**
     * Checks if the current iterator position is valid.
     *
     * @return bool true if the current position is valid, false otherwise
     */
    public function valid(): bool
    {
        return $this->innerIterator->valid();
    }
}
