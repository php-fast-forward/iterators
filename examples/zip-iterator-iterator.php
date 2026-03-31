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

use FastForward\Iterator\ZipIteratorIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample datasets for testing ZipIteratorIterator.
 *
 * @var ArrayIterator<int, int> $dataSetOne
 * @var ArrayIterator<int, string> $dataSetTwo
 * @var ArrayIterator<int, bool> $dataSetThree
 */
$dataSetOne   = new ArrayIterator([1, 2, 3, 4]);
$dataSetTwo   = new ArrayIterator(['A', 'B', 'C', 'D']);
$dataSetThree = new ArrayIterator([true, false, true, false]);

/**
 * Creates a ZipIteratorIterator to combine multiple iterators.
 *
 * @var ZipIteratorIterator<int, array{int, string, bool}>
 */
$zippedIterator = new ZipIteratorIterator($dataSetOne, $dataSetTwo, $dataSetThree);

// Debugging the output of ZipIteratorIterator.
debugIterable($zippedIterator, 'ZipIteratorIterator :: Combined Iteration');
