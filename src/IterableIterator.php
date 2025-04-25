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
 * Class IterableIterator.
 *
 * A normalized iterator wrapper that ensures any iterable (array or Traversable)
 * is treated as a standard \Iterator.
 *
 * This utility class simplifies iterator interoperability by converting arrays
 * into \ArrayIterator and wrapping \Traversable instances as needed. It SHALL
 * be used when an \Iterator is expected but the input MAY be any iterable.
 *
 * Example usage:
 *
 * ```php
 * $items = new IterableIterator([1, 2, 3]);
 *
 * foreach ($items as $item) {
 *     echo $item;
 * }
 * // Output: 123
 * ```
 *
 * @package FastForward\Iterator
 *
 * @since 1.1.0
 */
final class IterableIterator extends \IteratorIterator
{
    /**
     * Constructs an IterableIterator from any iterable input.
     *
     * Arrays are converted to \ArrayIterator; Traversables are passed directly.
     *
     * @param iterable $iterable the iterable to wrap as an \Iterator
     */
    public function __construct(iterable $iterable)
    {
        parent::__construct(
            $iterable instanceof \Traversable ? $iterable : new \ArrayIterator($iterable)
        );
    }
}
