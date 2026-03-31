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

use FastForward\Iterator\GroupByIteratorIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset for testing GroupByIteratorIterator.
 *
 * @var ArrayIterator<int, array{name: string, age: int}>
 */
$data = new ArrayIterator([
    [
        'name' => 'Alice',
        'age' => 25,
    ],
    [
        'name' => 'Bob',
        'age' => 30,
    ],
    [
        'name' => 'Charlie',
        'age' => 25,
    ],
    [
        'name' => 'David',
        'age' => 40,
    ],
    [
        'name' => 'Eve',
        'age' => 30,
    ],
]);

/**
 * Creates a GroupByIteratorIterator grouping by "age".
 *
 * @var GroupByIteratorIterator<int, array{name: string, age: int}>
 */
$groupedByAge = new GroupByIteratorIterator($data, static fn($item) => $item['age']);

// Debugging the output of GroupByIteratorIterator.
debugIterable($groupedByAge, 'GroupByIteratorIterator :: Grouped by Age');
