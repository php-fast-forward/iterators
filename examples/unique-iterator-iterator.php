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

use FastForward\Iterator\UniqueIteratorIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset for testing UniqueIteratorIterator.
 *
 * @var ArrayIterator<int, int|string>
 */
$data = new ArrayIterator([1, 2, 2, 3, 4, 4, 5, '5', 6, 6, 7, 'a', 'A', 'a']);

/**
 * Creates a UniqueIteratorIterator to filter out duplicate values.
 *
 * @var UniqueIteratorIterator<int|string>
 */
$uniqueIterator = new UniqueIteratorIterator($data, false, false);

// Debugging the output of UniqueIteratorIterator.
debugIterable($uniqueIterator, 'UniqueIteratorIterator :: Filtering Duplicates (non-strict strategy)');
