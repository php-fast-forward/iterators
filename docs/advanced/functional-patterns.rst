Functional Patterns
==================

Leverage closures for custom logic during iteration:

- ``ClosureIteratorIterator``: Wraps an iterator with a closure for filtering, mapping, or other logic.
- ``ClosureFactoryIteratorAggregate``: Factory for creating iterators from closures.

Example:

.. code-block:: php

   $it = new ArrayIterator([1,2,3]);
   $closure = new ClosureIteratorIterator($it, function ($value) {
       return $value * 2;
   });
   foreach ($closure as $val) {
       echo $val . "\n";
   }

**Expected output:**

.. code-block:: text

   2
   4
   6
