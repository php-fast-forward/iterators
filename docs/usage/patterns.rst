Choosing the Right Iterator
===========================

All public classes live under the ``FastForward\Iterator`` namespace. In most
cases you only need Composer autoloading plus the class you want to use:

.. code-block:: php

   require_once __DIR__ . '/vendor/autoload.php';

   use FastForward\Iterator\ChunkedIteratorAggregate;
   use FastForward\Iterator\SlidingWindowIteratorIterator;

Decision guide
--------------

.. list-table:: Start here when you are not sure which class to use
   :header-rows: 1
   :widths: 25 24 18 33

   * - If you want to...
     - Start with...
     - Output shape
     - Important behavior
   * - accept any array, generator, or traversable uniformly
     - ``IterableIterator``
     - same values
     - mostly used internally, but very helpful when writing your own wrappers
   * - split data into fixed-size batches
     - ``ChunkedIteratorAggregate``
     - ``array<int, mixed>``
     - the last chunk can be smaller
   * - inspect overlapping windows
     - ``SlidingWindowIteratorIterator``
     - ``array<int, mixed>``
     - yields nothing when the input is shorter than the window size
   * - transform each item lazily
     - ``ClosureIteratorIterator``
     - whatever your closure returns
     - your closure receives both value and key
   * - trim strings during iteration
     - ``TrimIteratorIterator``
     - trimmed strings
     - built on top of ``ClosureIteratorIterator``
   * - keep only first occurrences
     - ``UniqueIteratorIterator``
     - same values, deduplicated
     - supports ``strict`` and ``caseSensitive`` modes
   * - peek ahead or behind without consuming values
     - ``LookaheadIterator``
     - same values
     - ``lookAhead()`` and ``lookBehind()`` do not move the main iterator
   * - group consecutive runs
     - ``ConsecutiveGroupIterator``
     - arrays of consecutive items
     - groups are based on neighbors, not the whole dataset
   * - group the whole dataset by a computed key
     - ``GroupByIteratorIterator``
     - arrays keyed by group
     - all input is grouped on rewind before you iterate the groups
   * - merge sources one after another
     - ``ChainIterableIterator``
     - same values
     - numeric keys are normalized to sequential positions
   * - alternate between sources in round-robin order
     - ``InterleaveIteratorIterator``
     - same values
     - continues until every source is exhausted
   * - combine sources side by side
     - ``ZipIteratorIterator``
     - arrays of aligned values
     - stops as soon as the shortest source ends
   * - repeat values for a fixed number of reads
     - ``RepeatableIteratorIterator``
     - same values, repeated
     - good for controlled cycling, not infinite loops
   * - reuse a generator across multiple passes
     - ``GeneratorRewindableIterator``
     - same values
     - caches generated values so the iterator can be rewound
   * - keep a cached aggregate view of a generator
     - ``GeneratorCachingIteratorAggregate``
     - same values
     - useful when you prefer an aggregate over a direct iterator
   * - generate numeric or floating ranges lazily
     - ``RangeIterator``
     - integers or floats
     - step must be positive and not larger than the range length
   * - filter filesystem results by extension
     - ``FileExtensionFilterIterator``
     - ``SplFileInfo`` objects
     - recursive iterators are traversed recursively
   * - create a fresh iterable from a closure on each pass
     - ``ClosureFactoryIteratorAggregate``
     - depends on the closure result
     - ideal when you want lazy factory semantics

Beginner rules of thumb
-----------------------

- Prefer ``ChunkedIteratorAggregate`` when you need batches and
  ``SlidingWindowIteratorIterator`` when you need overlap.
- Prefer ``GroupByIteratorIterator`` when every matching item should end up in
  the same bucket, even if matching values are far apart.
- Prefer ``ConsecutiveGroupIterator`` when grouping depends on runs of adjacent
  values.
- Prefer ``ChainIterableIterator`` for append-like behavior,
  ``InterleaveIteratorIterator`` for fairness, and ``ZipIteratorIterator`` for
  pairwise alignment.
- If you are building your own abstractions, read :doc:`../api/foundations`
  before extending a base class.
