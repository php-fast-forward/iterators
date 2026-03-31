Quickstart
==========

Here's a minimal example to get you started:

.. code-block:: php

   use FastForward\Iterator\ChunkedIteratorAggregate;

   $data = range(1, 10);
   $chunked = new ChunkedIteratorAggregate($data, 3);
   foreach ($chunked as $chunk) {
       print_r($chunk);
   }

**Expected output:**

.. code-block:: text

   Array
   (
       [0] => 1
       [1] => 2
       [2] => 3
   )
   Array
   (
       [0] => 4
       [1] => 5
       [2] => 6
   )
   Array
   (
       [0] => 7
       [1] => 8
       [2] => 9
   )
   Array
   (
       [0] => 10
   )

See more examples in the `examples/ <https://github.com/php-fast-forward/iterators/blob/main/examples/>`__ directory.
