Usage Patterns
==============

This library is designed for flexible, composable iteration. All iterators and utilities are available under the ``FastForward\Iterator`` namespace. Simply require Composer's autoloader:

.. code-block:: php

   require_once 'vendor/autoload.php';

   use FastForward\Iterator\ChunkedIteratorAggregate;
   use FastForward\Iterator\SlidingWindowIteratorIterator;
   // ...

You can chain, compose, and adapt iterators for a wide variety of data processing tasks. See the next section for concrete use cases and code examples.
