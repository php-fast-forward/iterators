Examples
========

The ``examples/`` directory is one of the fastest ways to understand the
library. Each script is small, focused, and easy to run in isolation.

Suggested reading map
---------------------

.. list-table:: What each example teaches
   :header-rows: 1
   :widths: 38 62

   * - Example file
     - What to look for
   * - `chain-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/chain-iterator.php>`_
     - sequential combination of multiple iterables
   * - `chunked-iterator-aggregate.php <https://github.com/php-fast-forward/iterators/blob/main/examples/chunked-iterator-aggregate.php>`_
     - fixed-size batching with different chunk sizes
   * - `closure-factory-iterator-aggregate.php <https://github.com/php-fast-forward/iterators/blob/main/examples/closure-factory-iterator-aggregate.php>`_
     - factory-based lazy iterable creation
   * - `closure-iterator-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/closure-iterator-iterator.php>`_
     - value transformation with closures
   * - `consecutive-group-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/consecutive-group-iterator.php>`_
     - grouping adjacent runs
   * - `file-extension-filter-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/file-extension-filter-iterator.php>`_
     - filtering filesystem entries by extension
   * - `generator-caching-iterator-aggregate.php <https://github.com/php-fast-forward/iterators/blob/main/examples/generator-caching-iterator-aggregate.php>`_
     - replaying generator-backed aggregates
   * - `generator-rewindable-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/generator-rewindable-iterator.php>`_
     - rewinding generator output and repeating it
   * - `group-by-iterator-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/group-by-iterator-iterator.php>`_
     - full-dataset grouping by computed keys
   * - `interleave-iterator-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/interleave-iterator-iterator.php>`_
     - round-robin traversal and mixed key behavior
   * - `lookahead-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/lookahead-iterator.php>`_
     - peeking ahead and behind without consuming values
   * - `range-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/range-iterator.php>`_
     - integer, float, and boundary-aware ranges
   * - `repeatable-iterator-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/repeatable-iterator-iterator.php>`_
     - controlled repetition with limits and offsets
   * - `sliding-window-iterator-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/sliding-window-iterator-iterator.php>`_
     - overlapping windows of different sizes
   * - `trim-iterator-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/trim-iterator-iterator.php>`_
     - whitespace trimming and custom character masks
   * - `unique-iterator-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/unique-iterator-iterator.php>`_
     - strict and non-strict deduplication
   * - `zip-iterator-iterator.php <https://github.com/php-fast-forward/iterators/blob/main/examples/zip-iterator-iterator.php>`_
     - lockstep combination of several iterables

Recommended order
-----------------

If you are new to the package, a friendly order is:

1. ``chunked-iterator-aggregate.php``
2. ``sliding-window-iterator-iterator.php``
3. ``closure-iterator-iterator.php``
4. ``unique-iterator-iterator.php``
5. ``chain-iterator.php``
6. ``interleave-iterator-iterator.php``
7. ``zip-iterator-iterator.php``
