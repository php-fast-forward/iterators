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

use FastForward\Iterator\ClosureIteratorIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$data = [1, 2, 3, 4, 5];

/**
 * Creates a ClosureIteratorIterator that doubles each value in an iterable.
 *
 * @param array<int, int> $data the array of integers to iterate over
 *
 * @return ClosureIteratorIterator<int, int> the transformed iterator
 */
$doubleIterator = new ClosureIteratorIterator(
    new ArrayIterator($data),
    static fn (int $value): int => $value * 2
);

/**
 * Creates a ClosureIteratorIterator that transforms numbers into their string representations.
 *
 * @param array<int, int> $data the array of integers to iterate over
 *
 * @return ClosureIteratorIterator<int, string> the transformed iterator
 */
$stringIterator = new ClosureIteratorIterator(
    new ArrayIterator($data),
    static fn (int $value): string => "Number {$value}"
);

// Running test iterations
debugIterable($doubleIterator, 'ClosureIteratorIterator :: Doubling values');
debugIterable($stringIterator, 'ClosureIteratorIterator :: Converting to strings');
