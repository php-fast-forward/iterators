Combining Iterators
===================

This package ships three different "combine several sources" strategies. They
look similar at a glance but solve different problems.

Comparison table
----------------

.. list-table:: Chain vs interleave vs zip
   :header-rows: 1
   :widths: 24 32 44

   * - Class
     - What it does
     - Best fit
   * - ``ChainIterableIterator``
     - consumes one source completely, then moves to the next
     - paginated APIs, fallback lists, sequential data merges
   * - ``InterleaveIteratorIterator``
     - alternates between active sources in round-robin order
     - fairness-oriented scheduling, balanced output from uneven sources
   * - ``ZipIteratorIterator``
     - reads all sources in lockstep and yields tuples
     - pairwise alignment, parallel datasets, side-by-side records

Concrete example
----------------

.. code-block:: php

   use FastForward\Iterator\ChainIterableIterator;
   use FastForward\Iterator\InterleaveIteratorIterator;
   use FastForward\Iterator\ZipIteratorIterator;

   $letters = ['A', 'B', 'C'];
   $numbers = [1, 2];

   echo json_encode(iterator_to_array(new ChainIterableIterator($letters, $numbers), false)) . PHP_EOL;
   echo json_encode(iterator_to_array(new InterleaveIteratorIterator($letters, $numbers), false)) . PHP_EOL;
   echo json_encode(iterator_to_array(new ZipIteratorIterator($letters, $numbers), false)) . PHP_EOL;

Expected output:

.. code-block:: text

   ["A","B","C",1,2]
   ["A",1,"B",2,"C"]
   [["A",1],["B",2]]

Common mistakes
---------------

- If you expected ``ZipIteratorIterator`` to keep reading after the shortest
  input ends, you probably wanted ``ChainIterableIterator`` or
  ``InterleaveIteratorIterator`` instead.
- If you expected ``InterleaveIteratorIterator`` to preserve original numeric
  keys, note that numeric keys are normalized while string keys are preserved.
- If you only need to append several iterables, ``ChainIterableIterator`` is the
  simplest and easiest to reason about.
