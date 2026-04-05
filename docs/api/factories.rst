Factories & Utilities
====================

This package keeps helper APIs intentionally small. The main public helper
surfaces are one factory-style aggregate and one debugging function.

ClosureFactoryIteratorAggregate
-------------------------------

Use ``ClosureFactoryIteratorAggregate`` when a new traversal should call a
factory closure and obtain a fresh iterable source:

.. code-block:: php

   use FastForward\Iterator\ClosureFactoryIteratorAggregate;

   $factory = new ClosureFactoryIteratorAggregate(static function (): Generator {
       yield 'draft';
       yield 'review';
       yield 'publish';
   });

   foreach ($factory as $step) {
       echo $step . PHP_EOL;
   }

Why it is useful:

- it keeps lazy iterable creation inside one object;
- it works well with generators or ``ArrayIterator`` instances returned by a
  closure;
- every traversal starts from a fresh source produced by the closure.

Important note:

- if your generator uses ``return``, the returned value is not iterated. Only
  yielded values become part of the sequence.

debugIterable()
---------------

``debugIterable()`` is the quickest way to inspect a visible iterator state
during development:

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

The helper is especially convenient when:

- you are comparing two similar iterators and want to confirm the output shape;
- you are debugging grouped or zipped data;
- you want readable output without writing a temporary ``foreach`` every time.
