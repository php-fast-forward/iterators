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
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class ClosureIteratorIterator extends \IteratorIterator
{
    /**
     * @var \Closure the transformation function applied to each element
     */
    private readonly \Closure $closure;

    /**
     * Initializes the ClosureIteratorIterator.
     *
     * @param \Traversable $iterator the underlying iterator to wrap
     * @param \Closure     $closure  the transformation function applied to each element
     */
    public function __construct(\Traversable $iterator, \Closure $closure)
    {
        parent::__construct($iterator);
        $this->closure = $closure;
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
