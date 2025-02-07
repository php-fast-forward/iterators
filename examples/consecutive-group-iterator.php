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

use FastForward\Iterator\ConsecutiveGroupIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset for testing ConsecutiveGroupIterator.
 *
 * @var ArrayIterator<int, int> $dataSet
 */
$dataSet = new ArrayIterator([1, 1, 2, 2, 2, 3, 4, 4, 5]);

/**
 * Creates a ConsecutiveGroupIterator to group consecutive equal elements.
 *
 * @var ConsecutiveGroupIterator<int> $chunkedIterator
 */
$chunkedIterator = new ConsecutiveGroupIterator($dataSet, static fn ($previous, $current) => $previous === $current);

// Debugging the output of ConsecutiveGroupIterator.
debugIterable($chunkedIterator, 'ConsecutiveGroupIterator :: Grouped by Consecutive Values');
