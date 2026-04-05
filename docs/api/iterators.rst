Iterators
=========

This page covers the concrete iterators and iterator aggregates you are most
likely to instantiate directly.

Transformation and inspection
-----------------------------

.. list-table:: Transforming or inspecting a single source
   :header-rows: 1
   :widths: 25 35 40

   * - Class
     - Purpose
     - Important notes
   * - ``ClosureIteratorIterator``
     - applies a closure to every visible value
     - the closure receives both value and key
   * - ``TrimIteratorIterator``
     - trims strings lazily during iteration
     - built on top of ``ClosureIteratorIterator``
   * - ``UniqueIteratorIterator``
     - returns only first occurrences
     - key positions are normalized and options control strictness and case
       handling
   * - ``LookaheadIterator``
     - lets you inspect upcoming or previous values
     - ``lookAhead()`` and ``lookBehind()`` never advance the main iterator
   * - ``RangeIterator``
     - lazily generates integer or floating-point ranges
     - can force the final boundary when a step would overshoot it
   * - ``FileExtensionFilterIterator``
     - filters filesystem entries by extension
     - recursive iterators are traversed recursively before filtering

Grouping and segmentation
-------------------------

.. list-table:: Building grouped or windowed output
   :header-rows: 1
   :widths: 25 35 40

   * - Class
     - Purpose
     - Important notes
   * - ``ChunkedIteratorAggregate``
     - splits a source into fixed-size chunks
     - the last chunk can be shorter
   * - ``SlidingWindowIteratorIterator``
     - yields overlapping windows
     - produces no output if the source is shorter than the requested window
   * - ``ConsecutiveGroupIterator``
     - groups adjacent values while a callback keeps returning ``true``
     - useful for runs, streaks, and boundary detection
   * - ``GroupByIteratorIterator``
     - groups the whole dataset by a computed key
     - rewinding recomputes the full grouped structure

Combining and replaying sources
-------------------------------

.. list-table:: Working with more than one source or more than one pass
   :header-rows: 1
   :widths: 25 35 40

   * - Class
     - Purpose
     - Important notes
   * - ``ChainIterableIterator``
     - appends several iterables one after another
     - numeric keys are normalized to sequential positions
   * - ``InterleaveIteratorIterator``
     - alternates between sources in round-robin order
     - continues until all sources are exhausted
   * - ``ZipIteratorIterator``
     - aligns sources side by side into tuples
     - stops at the shortest input
   * - ``RepeatableIteratorIterator``
     - cycles through a source for a fixed number of reads
     - excellent for controlled repetition with a limit
   * - ``GeneratorRewindableIterator``
     - makes a generator reusable across loops
     - wraps cached generator output behind a direct iterator API
   * - ``GeneratorCachingIteratorAggregate``
     - exposes a cached aggregate view of a generator
     - useful when repeated iteration should still feel like an aggregate

When two classes look similar
-----------------------------

- ``ChunkedIteratorAggregate`` and ``SlidingWindowIteratorIterator`` both return
  arrays, but only sliding windows overlap.
- ``ConsecutiveGroupIterator`` groups neighbors, while
  ``GroupByIteratorIterator`` groups by computed bucket across the entire input.
- ``ChainIterableIterator``, ``InterleaveIteratorIterator``, and
  ``ZipIteratorIterator`` all combine sources, but they model append,
  round-robin, and lockstep behavior respectively.
- ``GeneratorRewindableIterator`` and ``GeneratorCachingIteratorAggregate`` both
  support repeated generator iteration; choose the one that best fits whether
  your API wants an iterator or an aggregate.

Suggested reading order for new users
-------------------------------------

If you are new to the package, a practical order is:

1. ``ChunkedIteratorAggregate``
2. ``SlidingWindowIteratorIterator``
3. ``ClosureIteratorIterator``
4. ``UniqueIteratorIterator``
5. ``ChainIterableIterator``, ``InterleaveIteratorIterator``, and
   ``ZipIteratorIterator``
6. ``LookaheadIterator`` and the generator replay classes

That sequence introduces output shapes gradually and reduces the amount of
iterator state you need to keep in your head at once.
