Use Cases
=========

- **Chunking data:**

  .. code-block:: php

   $chunked = new ChunkedIteratorAggregate(range(1, 10), 3);
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

- **Sliding window:**

  .. code-block:: php

   $window = new SlidingWindowIteratorIterator(new ArrayIterator([1,2,3,4,5]), 3);
   foreach ($window as $win) {
     print_r($win);
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

- **Unique filtering:**

  .. code-block:: php

   $unique = new UniqueIteratorIterator(new ArrayIterator([1,2,2,3,4,4,5]), false);
   foreach ($unique as $val) {
     echo $val . "\n";
   }

  **Expected output:**

  .. code-block:: text

   1
   2
   3
   4
   5

- **Lookahead/Lookbehind:**

  .. code-block:: php

   $lookahead = new LookaheadIterator(new ArrayIterator(['A','B','C']));
   foreach ($lookahead as $val) {
     echo $val . ' | Next: ' . json_encode($lookahead->lookAhead()) . "\n";
   }

  **Expected output:**

  .. code-block:: text

   A | Next: ["B"]
   B | Next: ["C"]
   C | Next: []

See the `examples/ <https://github.com/php-fast-forward/iterators/blob/main/examples/>`__ directory for more advanced scenarios.
