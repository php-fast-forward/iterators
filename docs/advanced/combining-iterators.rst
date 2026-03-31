Combining Iterators
==================

Combine multiple iterators in flexible ways using:

- ``ChainIterableIterator``: Chains multiple iterables into a single iterator.
- ``InterleaveIteratorIterator``: Interleaves elements from several iterators.
- ``ZipIteratorIterator``: Zips multiple iterators together, yielding tuples.

Example:

.. code-block:: php

    $a = new ArrayIterator([1,2,3]);
    $b = new ArrayIterator([4,5,6]);
    $chain = new ChainIterableIterator([$a, $b]);
    foreach ($chain as $val) {
         echo $val . "\n";
    }

**Expected output:**

.. code-block:: text

    1
    2
    3
    4
    5
    6
