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

use Closure;

/**
 * Class ClosureIteratorIterator.
 *
 * An extended IteratorIterator that applies a closure transformation
 * to each element during iteration.
 *
 * This class allows applying a transformation function dynamically
 * while iterating over an existing Traversable.
 *
 * ## Usage Example:
 *
 * @example
 * ```php
 * use FastForward\Iterator\ClosureIteratorIterator;
 * use ArrayIterator;
 *
 * $array = [1, 2, 3, 4, 5];
 *
 * $iterator = new ClosureIteratorIterator(
 *     new ArrayIterator($array),
 *     fn ($value) => $value * 2
 * );
 *
 * foreach ($iterator as $value) {
 *     echo $value; // Outputs: 2, 4, 6, 8, 10
 * }
 * ```
 *
 * @since 1.0.0
 */
class ClosureIteratorIterator extends CountableIteratorIterator
{
    /**
     * Initializes the ClosureIteratorIterator.
     *
     * @param iterable $iterator the underlying iterator to wrap
     * @param Closure $closure the transformation function applied to each element
     */
    public function __construct(
        iterable $iterator,
        private readonly Closure $closure
    ) {
        parent::__construct(new IterableIterator($iterator));
    }

    /**
     * Returns the current transformed element.
     *
     * The closure is applied to the original current element of the iterator.
     *
     * @return mixed the transformed element
     */
    public function current(): mixed
    {
        return \call_user_func($this->closure, parent::current(), parent::key());
    }
}
