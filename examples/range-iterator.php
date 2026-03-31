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

use FastForward\Iterator\RangeIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Number of elements to generate in the range.
 *
 * @var int
 */
$len = 5;

/**
 * Step size for iteration.
 *
 * @var float|int
 */
$step = 1.5;

/**
 * Creates an ascending range from 0 to $len with step size $step.
 *
 * @var RangeIterator<float|int>
 */
$ascending = new RangeIterator(0, $len, $step);

/**
 * Creates a descending range from $len to 0 with step size $step.
 *
 * @var RangeIterator<float|int>
 */
$descending = new RangeIterator($len, 0, $step, true);

// Debugging the output of the RangeIterator.
debugIterable($ascending, 'RangeIterator :: Ascending Strategy');
debugIterable($descending, 'RangeIterator :: Descending Strategy');
