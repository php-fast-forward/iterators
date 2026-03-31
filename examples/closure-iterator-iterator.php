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

use FastForward\Iterator\ClosureIteratorIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset for testing ClosureIteratorIterator..
 */
$data = [1, 2, 3, 4, 5];

/**
 * Creates a ClosureIteratorIterator that doubles each value in an iterable.
 *
 * @param array<int, int> $value the array of integers to iterate over
 *
 * @return ClosureIteratorIterator<int, int> the transformed iterator
 */
$doubleIterator = new ClosureIteratorIterator(
    $data,
    static fn(int $value): int => $value * 2
);

/**
 * Creates a ClosureIteratorIterator that transforms numbers into their string representations.
 *
 * @param array<int, int> $value the array of integers to iterate over
 *
 * @return ClosureIteratorIterator<int, string> the transformed iterator
 */
$stringIterator = new ClosureIteratorIterator(
    new ArrayIterator($data),
    static fn(int $value): string => 'Number ' . $value
);

// Running test iterations
debugIterable($doubleIterator, 'ClosureIteratorIterator :: Doubling values');
debugIterable($stringIterator, 'ClosureIteratorIterator :: Converting to strings');
