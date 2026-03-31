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

use FastForward\Iterator\ConsecutiveGroupIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset for testing ConsecutiveGroupIterator.
 *
 * @var array|ArrayIterator<int, int>
 */
$dataSet = [1, 1, 2, 2, 2, 1, 1, 3, 4, 4, 5];

/**
 * Creates a ConsecutiveGroupIterator to group consecutive equal elements.
 *
 * @var ConsecutiveGroupIterator<int>
 */
$chunkedIterator = new ConsecutiveGroupIterator($dataSet, static fn($previous, $current): bool => $previous === $current);

// Debugging the output of ConsecutiveGroupIterator.
debugIterable($chunkedIterator, 'ConsecutiveGroupIterator :: Grouped by Consecutive Values');
