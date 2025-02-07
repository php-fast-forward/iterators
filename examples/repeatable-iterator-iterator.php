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

use FastForward\Iterator\RepeatableIteratorIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Creates an ArrayIterator with sample data.
 *
 * @var ArrayIterator<int, string> $data
 */
$data = new ArrayIterator(['A', 'B', 'C', 'D', 'E']);

/**
 * Creates a RepeatableIteratorIterator with a limit of 10 items, starting from index 0.
 *
 * This allows cycling over a subset of the iterator.
 *
 * @var RepeatableIteratorIterator<string> $repeatableIterator
 */
$repeatableIterator = new RepeatableIteratorIterator($data, 10);

/**
 * Creates a RepeatableIteratorIterator with a limit of 10 items, starting from index 2.
 *
 * This demonstrates the behavior of the `$offset` parameter.
 *
 * @var RepeatableIteratorIterator<string> $repeatableIteratorWithOffset
 */
$repeatableIteratorWithOffset = new RepeatableIteratorIterator($data, 10, 2);

// Display the count of elements in the RepeatableIteratorIterator.
echo 'Total elements in repeatable iteration (default offset): ' . count($repeatableIterator) . PHP_EOL;
echo 'Total elements in repeatable iteration (offset = 2): ' . count($repeatableIteratorWithOffset) . PHP_EOL;

// Debugging iteration to show repeated cycling.
debugIterable($repeatableIterator, 'RepeatableIteratorIterator :: Default Offset');

// Debugging iteration with offset set to 2.
debugIterable($repeatableIteratorWithOffset, 'RepeatableIteratorIterator :: Offset = 2');
