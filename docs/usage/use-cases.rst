Use Cases
=========

This page shows complete scenarios rather than isolated API calls. Read it when
you already know the class names but still want help translating them into a
real workflow.

Batch records before writing to an external API
-----------------------------------------------

Use ``ChunkedIteratorAggregate`` when the receiving system expects fixed-size
payloads:

.. code-block:: php

   use FastForward\Iterator\ChunkedIteratorAggregate;

   $records = range(1, 7);

   foreach (new ChunkedIteratorAggregate($records, 3) as $batch) {
       // Send one request per batch.
       print_r($batch);
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
   )

Calculate moving comparisons
----------------------------

Use ``SlidingWindowIteratorIterator`` when each result needs to overlap with the
previous one:

.. code-block:: php

   use FastForward\Iterator\SlidingWindowIteratorIterator;

   $measurements = [10, 12, 13, 18, 21];

   foreach (new SlidingWindowIteratorIterator($measurements, 3) as $window) {
       echo json_encode($window) . PHP_EOL;
   }

Expected output:

.. code-block:: text

   [10,12,13]
   [12,13,18]
   [13,18,21]

Clean and deduplicate imported strings
--------------------------------------

You can compose iterators when the problem has more than one step:

.. code-block:: php

   use FastForward\Iterator\TrimIteratorIterator;
   use FastForward\Iterator\UniqueIteratorIterator;

   $rawTags = ['  PHP  ', 'php', ' Fast Forward ', 'PHP', 'fast forward'];

   $trimmed = new TrimIteratorIterator($rawTags);
   $unique = new UniqueIteratorIterator($trimmed, true, false);

   foreach ($unique as $tag) {
       echo $tag . PHP_EOL;
   }

Expected output:

.. code-block:: text

   PHP
   Fast Forward

Understand grouping choices
---------------------------

``ConsecutiveGroupIterator`` and ``GroupByIteratorIterator`` solve related but
different problems:

.. code-block:: php

   use FastForward\Iterator\ConsecutiveGroupIterator;
   use FastForward\Iterator\GroupByIteratorIterator;

   $values = [1, 1, 2, 2, 1];

   $consecutive = new ConsecutiveGroupIterator(
       $values,
       static fn(int $previous, int $current): bool => $previous === $current
   );

   $grouped = new GroupByIteratorIterator(
       $values,
       static fn(int $value): int => $value
   );

   print_r(iterator_to_array($consecutive, false));
   print_r(iterator_to_array($grouped));

Expected output:

.. code-block:: text

   Array
   (
       [0] => Array
           (
               [0] => 1
               [1] => 1
           )
       [1] => Array
           (
               [0] => 2
               [1] => 2
           )
       [2] => Array
           (
               [0] => 1
           )
   )
   Array
   (
       [1] => Array
           (
               [0] => 1
               [1] => 1
               [2] => 1
           )
       [2] => Array
           (
               [0] => 2
               [1] => 2
           )
   )

Combine multiple sources deliberately
-------------------------------------

These three classes are easy to confuse, so it helps to see them side by side:

.. code-block:: php

   use FastForward\Iterator\ChainIterableIterator;
   use FastForward\Iterator\InterleaveIteratorIterator;
   use FastForward\Iterator\ZipIteratorIterator;

   $left = ['A', 'B', 'C'];
   $right = [1, 2];

   echo json_encode(iterator_to_array(new ChainIterableIterator($left, $right), false)) . PHP_EOL;
   echo json_encode(iterator_to_array(new InterleaveIteratorIterator($left, $right), false)) . PHP_EOL;
   echo json_encode(iterator_to_array(new ZipIteratorIterator($left, $right), false)) . PHP_EOL;

Expected output:

.. code-block:: text

   ["A","B","C",1,2]
   ["A",1,"B",2,"C"]
   [["A",1],["B",2]]

Reuse an expensive generator
----------------------------

Plain generators are single-pass. Reach for ``GeneratorRewindableIterator`` or
``GeneratorCachingIteratorAggregate`` when you need more than one iteration:

.. code-block:: php

   use FastForward\Iterator\GeneratorRewindableIterator;

   $source = new GeneratorRewindableIterator((function (): Generator {
       yield 'first';
       yield 'second';
   })());

   echo json_encode(iterator_to_array($source, false)) . PHP_EOL;
   echo json_encode(iterator_to_array($source, false)) . PHP_EOL;

Expected output:

.. code-block:: text

   ["first","second"]
   ["first","second"]

Inspect upcoming and previous values
------------------------------------

``LookaheadIterator`` is helpful when parsing token-like streams or building
state machines:

.. code-block:: php

   use FastForward\Iterator\LookaheadIterator;

   $iterator = new LookaheadIterator(['A', 'B', 'C']);

   foreach ($iterator as $value) {
       echo $value
           . ' | next=' . json_encode($iterator->lookAhead())
           . ' | prev=' . json_encode($iterator->lookBehind())
           . PHP_EOL;
   }

Expected output:

.. code-block:: text

   A | next="B" | prev=null
   B | next="C" | prev="A"
   C | next=null | prev="B"

Filter a directory by extension
-------------------------------

Use ``FileExtensionFilterIterator`` when you already have a filesystem iterator
and only want specific file types:

.. code-block:: php

   use FastForward\Iterator\FileExtensionFilterIterator;

   $files = new FileExtensionFilterIterator(
       new FilesystemIterator(__DIR__),
       'php',
       'rst'
   );

   foreach ($files as $file) {
       echo $file->getFilename() . PHP_EOL;
   }

See the `examples directory <https://github.com/php-fast-forward/iterators/tree/main/examples>`_
for more package-specific demonstrations.
