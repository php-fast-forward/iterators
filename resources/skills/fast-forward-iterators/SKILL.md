---
name: fast-forward-iterators
description: Use Fast Forward iterators for chunks and lookahead, handling normalization, empty inputs, rewind limits and invalid peek counts.
license: MIT; see LICENSE
compatibility: Supports fast-forward/iterators ^1.3 and PHP ^8.3. Requires Composer and declared extensions; inspect the installed version. Earlier releases are outside this contract.
metadata:
  author: Fast Forward
  api-baseline: fast-forward/iterators ^1.3
---

# Process iterable data

Use this skill for an application consuming `fast-forward/iterators:^1.3`.
Read its instructions, manifest/lockfile and installed source before editing.
Run `composer show fast-forward/iterators`. For versions outside this contract,
inspect matching documentation; do not silently upgrade the application.

## First working integration

Requires PHP ^8.3, Composer's application autoloader and this package's runtime
dependencies.
With authority to install the dependency:

```sh
composer require 'fast-forward/iterators:^1.3'
```

Create `app.php` in the application root alongside composer.json/vendor:

```php
<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

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

echo "integration ready\n";
```

Run `php app.php`. It throws on a wrong result; success prints
`integration ready`. It uses no production data and starts no server.

## Wiring and failure boundaries

The Composer package is plural `fast-forward/iterators`, while the namespace is singular `FastForward\Iterator`. No provider/config is required. Wrap the application's iterable explicitly and consume it with foreach; materialize with iterator_to_array only when the dataset is bounded.

ChunkedIteratorAggregate emits value arrays, discards input keys, emits a partial last chunk, and normalizes sizes below one to one. Empty input emits no chunk. Validate an application chunk-size setting first when silently normalizing zero would hide a configuration error.

LookaheadIterator::lookAhead() and lookBehind() are the public method names, not peek()/prev(). Counts below one throw InvalidArgumentException; looking beyond the available range can return null. The wrapper needs seek/rewind behavior internally. Use a reusable array as its input. For a bounded generator, materialize its values into an array before constructing the lookahead wrapper; do not materialize an unbounded stream.

ClosureFactoryIteratorAggregate can create a fresh generator for each independent traversal of the aggregate. It does not make a generator-backed input rewindable inside LookaheadIterator: the inner IterableIterator resolves one generator, and lookahead's internal rewinds do not invoke the factory again. Do not use a generator or a generator-backed factory aggregate as a rewind-safe lookahead input. The complete example checks independent factory traversals separately from repeated lookahead over an array.

Counting a traversal can consume it; test repeated traversal against the actual source. Chunked results are incremental, but caching/unique/grouping and lookahead wrappers can retain data. Choose a wrapper from the installed source/API rather than inventing a fluent map/filter DSL.

## Verify integration

Run the [complete example](examples/integration.php) against the application's
autoloader in a disposable process. It checks success and negative cases:

```sh
php /path/to/fast-forward-iterators/examples/integration.php ./vendor/autoload.php
```

Expected final marker: `fast-forward-iterators: ok`. Keep application-specific regression
tests in its existing PHPUnit suite, with each fixture class in its same-named
file. File copying, host discovery and completed agent tasks are different checks.
For optional copying/synchronization load
[installation and lifecycle](references/installation.md).
