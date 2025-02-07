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
 * Class GeneratorCachingIteratorAggregate.
 *
 * A caching iterator aggregate designed to wrap a generator and cache its results.
 *
 * This class allows wrapping a `Generator` or a `callable` returning a generator,
 * caching its values to enable multiple iterations over the same dataset.
 *
 * ## Usage Example:
 *
 * @example Using a Generator
 * ```php
 * use FastForward\Iterator\GeneratorCachingIteratorAggregate;
 *
 * $iterator = new GeneratorCachingIteratorAggregate(
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
 *     echo $value; // Outputs: A B C (cached)
 * }
 * ```
 * @example Using a Callable that Returns a Generator
 * ```php
 * use FastForward\Iterator\GeneratorCachingIteratorAggregate;
 *
 * $iterator = new GeneratorCachingIteratorAggregate(fn () => (function () {
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
 *     echo $value; // Outputs: 1 2 3 (cached)
 * }
 * ```
 *
 * **Note:** If a callable is provided, it is automatically converted to a generator
 * using `ClosureFactoryIteratorAggregate`.
 *
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class GeneratorCachingIteratorAggregate implements \IteratorAggregate
{
    /**
     * @var \CachingIterator the caching iterator that stores generated values
     */
    private \CachingIterator $cachingIterator;

    /**
     * Initializes the caching iterator with a generator or a callable returning a generator.
     *
     * If a callable is provided, it is wrapped in a `ClosureFactoryIteratorAggregate` to generate the iterator.
     *
     * @param callable|\Generator $generator the generator or a callable returning a generator
     */
    public function __construct(callable|\Generator $generator)
    {
        if (\is_callable($generator)) {
            $generator = (new ClosureFactoryIteratorAggregate($generator))->getIterator();
        }

        $this->cachingIterator = new \CachingIterator($generator, \CachingIterator::FULL_CACHE);
    }

    /**
     * Retrieves the iterator, either from the cache or the generator itself.
     *
     * This method ensures that once a generator is iterated, its values
     * remain available for subsequent iterations.
     *
     * @return \Traversable the cached or fresh iterator
     */
    public function getIterator(): \Traversable
    {
        if ($this->cachingIterator->getCache()) {
            yield from $this->cachingIterator->getCache();
        } else {
            yield from $this->cachingIterator;
        }
    }
}
