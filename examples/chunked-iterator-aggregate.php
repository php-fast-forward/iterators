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

use FastForward\Iterator\ChunkedIteratorAggregate;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset to be chunked.
 *
 * @var array<int, int>
 */
$data = range(1, 10);

/**
 * Creates a ChunkedIteratorAggregate with a chunk size of 3.
 *
 * This splits the data into subarrays of at most 3 elements each.
 *
 * @var ChunkedIteratorAggregate<int>
 */
$chunkedIterator = new ChunkedIteratorAggregate($data, 3);

/**
 * Creates a ChunkedIteratorAggregate with a chunk size of 4.
 *
 * This demonstrates how different chunk sizes affect iteration.
 *
 * @var ChunkedIteratorAggregate<int>
 */
$chunkedIteratorFour = new ChunkedIteratorAggregate(new ArrayIterator($data), 4);

// Debugging the ChunkedIteratorAggregate output.
debugIterable($chunkedIterator, 'ChunkedIteratorAggregate :: Chunk size 3');
debugIterable($chunkedIteratorFour, 'ChunkedIteratorAggregate :: Chunk size 4');
