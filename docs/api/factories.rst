Factories & Utilities
====================

- **ClosureFactoryIteratorAggregate**: Factory for creating iterators from closures.
- **functions.php**: Contains utility functions such as ``debugIterable`` for debugging iterables.

.. code-block:: php

    use function FastForward\Iterator\debugIterable;

    $it = new ArrayIterator([1,2,3]);
    debugIterable($it, 'Section Title');

**Expected output:**

.. code-block:: text

    === Section Title ===

    Length: 3
    Output: [
      0 => "1",
      1 => "2",
      2 => "3",
    ]

