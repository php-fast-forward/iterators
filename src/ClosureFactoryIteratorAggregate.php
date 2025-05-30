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
 * Class ClosureFactoryIteratorAggregate.
 *
 * Provides an iterator implementation based on a closure factory.
 *
 * This class allows dynamic generation of iterators using a provided closure.
 * It is particularly useful in scenarios where deferred computation or dynamic
 * iterable generation is needed.
 *
 * ## Usage Examples:
 *
 * ### Using Generator Function:
 *
 * @example
 * ```php
 * use FastForward\Iterator\ClosureFactoryIteratorAggregate;
 *
 * $iterator = new ClosureFactoryIteratorAggregate(function () {
 *      yield 1;
 *      yield 2;
 *      yield 3;x
 * });
 *
 * foreach ($iterator as $value) {
 *     echo $value; // Outputs: 1 2 3
 * }
 * ```
 *
 * ### Using Array Iterator:
 * @example
 * ```php
 * use FastForward\Iterator\ClosureFactoryIteratorAggregate;
 * use ArrayIterator;
 *
 * $array = [10, 20, 30];
 * $iterator = new ClosureFactoryIteratorAggregate(fn () => new ArrayIterator($array));
 *
 * foreach ($iterator as $value) {
 *     echo $value; // Outputs: 10 20 30
 * }
 * ```
 *
 * ### Generator with `return` Statement:
 * @example
 * ```php
 * use FastForward\Iterator\ClosureFactoryIteratorAggregate;
 *
 * $iterator = new ClosureFactoryIteratorAggregate(
 *     fn () => (function () {
 *         yield 'A';
 *         yield 'B';
 *         return 'This will not be iterated';
 *     })()
 * );
 *
 * foreach ($iterator as $value) {
 *     echo $value; // Outputs: A B
 * }
 * ```
 * **Note:** If a `Generator` function includes a `return` statement,
 * its return value will **not** be iterated.
 *
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class ClosureFactoryIteratorAggregate implements \IteratorAggregate
{
    /**
     * @var \Closure the factory function responsible for producing the iterator
     */
    private \Closure $factory;

    /**
     * Initializes the ClosureFactoryIteratorAggregate with a closure.
     *
     * @param \Closure $factory a function that returns an iterable structure
     */
    public function __construct(\Closure $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Retrieves the iterator generated by the factory closure.
     *
     * This method invokes the provided closure and returns the resulting `Traversable` instance.
     *
     * **Important:** If the generator contains a `return` statement, its return value **will not** be iterated.
     *
     * @return \Traversable the iterator generated by the factory function
     */
    public function getIterator(): \Traversable
    {
        return new IterableIterator(\call_user_func($this->factory));
    }
}
