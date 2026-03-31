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

use Traversable;
use ArrayIterator;

/**
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
 * @since 1.1.0
 */
final class IterableIterator extends CountableIteratorIterator
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
            $iterable instanceof Traversable ? $iterable : new ArrayIterator($iterable)
        );
    }
}
