<?php

declare(strict_types=1);

require $argv[1] ?? dirname(__DIR__, 4) . '/vendor/autoload.php';

use FastForward\Iterator\ChunkedIteratorAggregate;
use FastForward\Iterator\ClosureFactoryIteratorAggregate;
use FastForward\Iterator\LookaheadIterator;

$chunks = iterator_to_array(new ChunkedIteratorAggregate([1, 2, 3, 4, 5], 2), false);
if ($chunks !== [[1, 2], [3, 4], [5]]
    || iterator_to_array(new ChunkedIteratorAggregate([], 2), false) !== []
    || iterator_to_array(new ChunkedIteratorAggregate([1, 2], 0), false) !== [[1], [2]]) {
    throw new RuntimeException('Chunk boundaries differ.');
}
$values = ['a', 'b', 'c'];
$factoryCalls = 0;
$factory = new ClosureFactoryIteratorAggregate(static function () use (&$factoryCalls, $values): Generator {
    ++$factoryCalls;
    yield from $values;
});
if (iterator_to_array($factory, false) !== $values
    || iterator_to_array($factory, false) !== $values
    || $factoryCalls !== 2) {
    throw new RuntimeException('Independent traversals must invoke the generator factory again.');
}

// Lookahead needs a rewindable input; a generator factory is not a substitute.
$lookahead = new LookaheadIterator($values);
$lookahead->rewind();
if ($lookahead->current() !== 'a' || $lookahead->lookAhead() !== 'b' || $lookahead->current() !== 'a') {
    throw new RuntimeException('Lookahead moved the current item.');
}
$lookahead->next();
if ($lookahead->current() !== 'b' || $lookahead->lookAhead() !== 'c') {
    throw new RuntimeException('Lookahead did not follow the current position.');
}
$lookahead->rewind();
if ($lookahead->current() !== 'a' || $lookahead->lookAhead() !== 'b' || $lookahead->current() !== 'a') {
    throw new RuntimeException('Array-backed lookahead did not rewind safely.');
}
try {
    $lookahead->lookAhead(0);
    throw new RuntimeException('An invalid peek count unexpectedly succeeded.');
} catch (InvalidArgumentException) {
}

echo "fast-forward-iterators: ok\n";
