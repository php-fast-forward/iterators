Caching & Rewinding
===================

Generators are naturally single-pass, which is perfect for streaming but
problematic when your workflow needs a second iteration. This package offers
three related tools for that situation.

Comparison guide
----------------

.. list-table:: Choose the replay strategy that matches your API
   :header-rows: 1
   :widths: 28 30 42

   * - Class
     - Best when...
     - Important note
   * - ``GeneratorCachingIteratorAggregate``
     - you want an aggregate that can be iterated repeatedly
     - cached values remain available after the first traversal
   * - ``GeneratorRewindableIterator``
     - you want a direct iterator that feels like a reusable generator
     - rewinding rebuilds the visible iterator from cached values
   * - ``RepeatableIteratorIterator``
     - you want a fixed number of repeated reads from a finite source
     - designed for controlled repetition, not for infinite processing loops

Example with repeated generator reads
-------------------------------------

.. code-block:: php

   use FastForward\Iterator\GeneratorRewindableIterator;

   $generator = new GeneratorRewindableIterator((function (): Generator {
       yield from [1, 2, 3];
   })());

   foreach ($generator as $value) {
       echo $value . PHP_EOL;
   }

   foreach ($generator as $value) {
       echo $value . PHP_EOL;
   }

Expected output:

.. code-block:: text

   1
   2
   3
   1
   2
   3

Memory trade-off
----------------

Replayable iteration depends on caching. That means:

- it is a good fit for medium-sized or expensive-to-produce sequences;
- it is a poor fit for very large unbounded streams;
- you should document the buffering behavior clearly if you build your own
  generator wrappers on top of these classes.
