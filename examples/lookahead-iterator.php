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

use FastForward\Iterator\LookaheadIterator;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset for testing LookaheadIterator.
 *
 * @var ArrayIterator<int, string> $dataSet
 */
$dataSet = new ArrayIterator(['A', 'B', 'C', 'D', 'E']);

/**
 * Creates a LookaheadIterator to enable peeking at the next and previous value(s).
 *
 * @var LookaheadIterator<string> $lookaheadIterator
 */
$lookaheadIterator = new LookaheadIterator($dataSet);

// Demonstrates peeking at the next value(s) and retrieving previous value(s) while iterating.
foreach ($lookaheadIterator as $value) {
    echo 'Current: ' . $value
        . ' | Next: ' . json_encode($lookaheadIterator->lookAhead())
        . ' | Next 2: ' . json_encode($lookaheadIterator->lookAhead(2))
        . ' | Next 3: ' . json_encode($lookaheadIterator->lookAhead(3))
        . ' | Prev: ' . json_encode($lookaheadIterator->lookBehind())
        . ' | Prev 2: ' . json_encode($lookaheadIterator->lookBehind(2)) . PHP_EOL;
}
