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
 * Prints a debug representation of an iterable object.
 *
 * This function iterates over a `Traversable` object and prints each key-value pair,
 * along with an optional section title. If no section title is provided, the function
 * uses the class name of the iterable object.
 *
 * ## Example Usage:
 *
 * @example
 * ```php
 * use FastForward\Iterator\debugIterable;
 * use ArrayIterator;
 *
 * $iterator = new ArrayIterator(['a' => 1, 'b' => 2, 'c' => 3]);
 *
 * debugIterable($iterator, 'Example Output');
 * ```
 *
 * **Output:**
 * ```
 * === Example Output ===
 *  - Key: "a"
 *    Value: "1"
 *  - Key: "b"
 *    Value: "2"
 *  - Key: "c"
 *    Value: "3"
 * ```
 *
 * @param \Traversable $iteratable the iterable object to debug
 * @param null|string  $section    an optional title for the output section
 */
function debugIterable(\Traversable $iteratable, ?string $section = null): void
{
    if (!$section) {
        $section = $iteratable::class;
    }

    printf('=== %s ===%s', $section, PHP_EOL);

    foreach ($iteratable as $key => $value) {
        if (!\is_scalar($value)) {
            $value = json_encode($value);
        }

        printf(' - Key: "%s" %s   Value: "%s" %s', $key, PHP_EOL, $value, PHP_EOL);
    }
}
