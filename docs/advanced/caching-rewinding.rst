Caching & Rewinding
===================

- ``GeneratorCachingIteratorAggregate``: Caches generator results for repeatable iteration.
- ``GeneratorRewindableIterator``: Allows rewinding generators, making them reusable.

Example:

.. code-block:: php

   $generator = function () {
       yield from [1,2,3];
   };
   $caching = new GeneratorCachingIteratorAggregate($generator());
   foreach ($caching as $val) {
       echo $val . "\n";
   }
   // Can iterate again without loss.

**Expected output:**

.. code-block:: text

   1
   2
   3
