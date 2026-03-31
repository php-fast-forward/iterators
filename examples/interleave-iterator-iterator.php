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

use FastForward\Iterator\InterleaveIteratorIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset for testing InterleaveIteratorIterator.
 *
 * @var ArrayIterator<int, int> $data1
 * @var ArrayIterator<int, int> $data2
 * @var ArrayIterator<int, int> $data3
 */
$data1 = [1, 4, 7];
$data2 = new ArrayIterator([
    2,
    'test' => 5,
    8,
]);
$data3 = new ArrayIterator([
    3,
    6,
    9,
    'test' => 123,
]);

/**
 * Creates an InterleaveIteratorIterator interleaving three iterators.
 *
 * @var InterleaveIteratorIterator<int>
 */
$interleaved = new InterleaveIteratorIterator($data1, $data2, $data3);

// Debugging the output of InterleaveIteratorIterator.
debugIterable($interleaved, 'InterleaveIteratorIterator :: Interleaved Iteration');
