Debugging Iterables
==================

Use the utility function ``debugIterable()`` to print and inspect any traversable object during development.

Example:

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

This prints each key-value pair, helping you understand the state of your iterators.
