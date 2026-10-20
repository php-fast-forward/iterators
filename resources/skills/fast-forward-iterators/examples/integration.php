<?php

declare(strict_types=1);

require $argv[1] ?? dirname(__DIR__, 4) . '/vendor/autoload.php';

use FastForward\Iterator\ChunkedIteratorAggregate;
use FastForward\Iterator\LookaheadIterator;

$chunks = iterator_to_array(new ChunkedIteratorAggregate([1, 2, 3, 4, 5], 2), false);
if ($chunks !== [[1, 2], [3, 4], [5]]
    || iterator_to_array(new ChunkedIteratorAggregate([], 2), false) !== []
    || iterator_to_array(new ChunkedIteratorAggregate([1, 2], 0), false) !== [[1], [2]]) {
    throw new RuntimeException('Chunk boundaries differ.');
}
$lookahead = new LookaheadIterator(['a', 'b']);
$lookahead->rewind();
if ($lookahead->current() !== 'a' || $lookahead->lookAhead() !== 'b' || $lookahead->current() !== 'a') {
    throw new RuntimeException('Lookahead moved the current item.');
}
try {
    $lookahead->lookAhead(0);
    throw new RuntimeException('An invalid peek count unexpectedly succeeded.');
} catch (InvalidArgumentException) {
}

echo "fast-forward-iterators: ok\n";
