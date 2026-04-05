Quickstart
==========

The example below shows the general feel of the library:

1. pass any iterable as input;
2. wrap it in an iterator that expresses the behavior you want;
3. iterate over the resulting values.

Chunking is a good first example because the output is easy to inspect:

.. code-block:: php

   require_once __DIR__ . '/vendor/autoload.php';

   use FastForward\Iterator\ChunkedIteratorAggregate;

   $data = range(1, 10);
   $chunked = new ChunkedIteratorAggregate($data, 3);

   foreach ($chunked as $chunk) {
       print_r($chunk);
   }

Expected output:

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

What happened here
------------------

- ``range(1, 10)`` creates the input data.
- ``ChunkedIteratorAggregate`` groups the values into arrays of three items.
- The last chunk can be smaller when the source length is not a perfect
  multiple of the chunk size.

Try one more example
--------------------

Once the chunking example feels natural, try a second iterator with a different
output shape:

.. code-block:: php

   use FastForward\Iterator\SlidingWindowIteratorIterator;

   $windows = new SlidingWindowIteratorIterator([1, 2, 3, 4, 5], 3);

   foreach ($windows as $window) {
       print_r($window);
   }

Expected output:

.. code-block:: text

   Array
   (
       [0] => 1
       [1] => 2
       [2] => 3
   )
   Array
   (
       [0] => 2
       [1] => 3
       [2] => 4
   )
   Array
   (
       [0] => 3
       [1] => 4
       [2] => 5
   )

The difference between both examples is important:

- chunking creates non-overlapping groups;
- sliding windows create overlapping groups.

See the `examples directory <https://github.com/php-fast-forward/iterators/tree/main/examples>`_
for more complete samples.
