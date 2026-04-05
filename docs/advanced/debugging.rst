Debugging Iterables
===================

Use ``debugIterable()`` when you want a quick snapshot of what an iterator is
currently exposing without writing custom dump code around every experiment.

Basic usage
-----------

.. code-block:: php

   use function FastForward\Iterator\debugIterable;

   $it = new ArrayIterator([1, 2, 3]);
   debugIterable($it, 'Section Title');

Expected output:

.. code-block:: text

   === Section Title ===

   Length: 3
   Output: [
     0 => 1,
     1 => 2,
     2 => 3,
   ]

When it is especially useful
----------------------------

- after composing several iterators and losing track of the final output shape;
- while comparing ``ChainIterableIterator``, ``InterleaveIteratorIterator``, and
  ``ZipIteratorIterator``;
- while checking how grouping iterators structure their arrays;
- while verifying whether keys were preserved or normalized.

Tips
----

- Pass a section title so multiple debug blocks are easy to scan in one script.
- Debug early in the pipeline and again at the end if you are composing several
  wrappers.
- Remember that ``debugIterable()`` calls ``count()``. That is useful, but it
  also means the underlying iterator should support safe counting.
