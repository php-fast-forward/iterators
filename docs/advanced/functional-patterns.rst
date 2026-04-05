Functional Patterns
==================

Closures are a big part of what makes this library expressive. They let you keep
iteration lazy while still injecting project-specific logic.

Two core closure-based tools
----------------------------

.. list-table:: Closure-oriented building blocks
   :header-rows: 1
   :widths: 30 70

   * - Class
     - Use it when...
   * - ``ClosureIteratorIterator``
     - you already have a source and want to transform each visible value
   * - ``ClosureFactoryIteratorAggregate``
     - you want each traversal to create a fresh iterable source lazily

Transform values lazily
-----------------------

.. code-block:: php

   use FastForward\Iterator\ClosureIteratorIterator;

   $it = new ArrayIterator([1, 2, 3]);
   $closure = new ClosureIteratorIterator($it, function (int $value): int {
       return $value * 2;
   });

   foreach ($closure as $val) {
       echo $val . PHP_EOL;
   }

Expected output:

.. code-block:: text

   2
   4
   6

Important details
-----------------

- ``ClosureIteratorIterator`` passes both the current value and the current key
  to your closure.
- exceptions thrown inside the closure bubble up naturally, which is often what
  you want in validation-heavy pipelines.
- ``TrimIteratorIterator`` is an example of a higher-level iterator built on top
  of ``ClosureIteratorIterator``.
