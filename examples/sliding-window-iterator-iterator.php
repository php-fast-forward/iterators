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

use FastForward\Iterator\SlidingWindowIteratorIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset for testing SlidingWindowIteratorIterator.
 *
 * @var ArrayIterator<int, int>
 */
$data = new ArrayIterator([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

/**
 * Creates a SlidingWindowIteratorIterator with a window size of 3.
 *
 * @var SlidingWindowIteratorIterator<int>
 */
$slidingWindow = new SlidingWindowIteratorIterator($data, 3);

// Debugging first iteration over the SlidingWindowIteratorIterator.
debugIterable($slidingWindow, 'SlidingWindowIteratorIterator :: Window Size 3');

/**
 * Creates another SlidingWindowIteratorIterator with a larger window size of 5.
 *
 * @var SlidingWindowIteratorIterator<int>
 */
$slidingWindowLarge = new SlidingWindowIteratorIterator($data, 5);

// Debugging iteration with a larger window size.
debugIterable($slidingWindowLarge, 'SlidingWindowIteratorIterator :: Window Size 5');
