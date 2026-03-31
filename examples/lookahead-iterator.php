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

use FastForward\Iterator\LookaheadIterator;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset for testing LookaheadIterator.
 *
 * @var ArrayIterator<int, string>
 */
$dataSet = new ArrayIterator(['A', 'B', 'C', 'D', 'E']);

/**
 * Creates a LookaheadIterator to enable peeking at the next and previous value(s).
 *
 * @var LookaheadIterator<string>
 */
$lookaheadIterator = new LookaheadIterator($dataSet);

// Demonstrates peeking at the next value(s) and retrieving previous value(s) while iterating.
foreach ($lookaheadIterator as $value) {
    echo 'Current: ' . $value
        . ' | Next: ' . json_encode($lookaheadIterator->lookAhead())
        . ' | Next 2: ' . json_encode($lookaheadIterator->lookAhead(2))
        . ' | Next 3: ' . json_encode($lookaheadIterator->lookAhead(3))
        . ' | Prev: ' . json_encode($lookaheadIterator->lookBehind())
        . ' | Prev 2: ' . json_encode($lookaheadIterator->lookBehind(2)) . \PHP_EOL;
}
