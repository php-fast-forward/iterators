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

use Stringable;

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
 *
 * Length: 3
 * Output: [
 *   "a" => 1,
 *   "b" => 2,
 *   0 => 3,
 * ]
 * ```
 *
 * @param iterable $iterable the iterable object to debug
 * @param string|null $section an optional title for the output section
 */
function debugIterable(iterable $iterable, ?string $section = null): void
{
    if (! $section) {
        $section = $iterable::class;
    }

    printf(
        '=== %s ===%s%sLength: %d%sOutput: [%s',
        $section,
        \PHP_EOL,
        \PHP_EOL,
        \count($iterable),
        \PHP_EOL,
        \PHP_EOL
    );

    foreach ($iterable as $key => $value) {
        if (\is_string($key)) {
            $key = \sprintf('"%s"', $key);
        }

        if (\is_string($value) || $value instanceof Stringable) {
            $value = \sprintf('"%s"', $value);
        }

        if (! \is_scalar($value)) {
            $value = json_encode($value, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE);
        }

        printf('%s%s => %s,%s', '  ', $key, $value, \PHP_EOL);
    }

    printf(']%s', \PHP_EOL);
}
