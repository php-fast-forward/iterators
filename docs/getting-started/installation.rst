Installation
============

Requirements
------------

- PHP 8.3 or newer
- Composer
- standard SPL iterator classes, which are part of PHP itself

Install with Composer
---------------------

Install the package published in ``composer.json``:

.. code-block:: bash

   composer require fast-forward/iterators

Project notes
-------------

- The package has no additional runtime Composer dependencies.
- Most classes accept plain arrays, ``Traversable`` objects, generators, or
  existing SPL iterators.
- String-oriented features call ``mb_*`` helpers. If you plan to use
  ``TrimIteratorIterator``, ``FileExtensionFilterIterator``, or
  case-insensitive ``UniqueIteratorIterator`` workflows, keep ``ext-mbstring``
  enabled in your PHP runtime.

Verify the installation
-----------------------

Create a small script and confirm that Composer autoloading is working:

.. code-block:: php

   <?php

   declare(strict_types=1);

   require_once __DIR__ . '/vendor/autoload.php';

   use FastForward\Iterator\RangeIterator;

   foreach (new RangeIterator(1, 3) as $value) {
       echo $value . PHP_EOL;
   }

Expected output:

.. code-block:: text

   1
   2
   3

What to read next
-----------------

- Continue with :doc:`quickstart` for your first real example.
- Jump to :doc:`../usage/patterns` if you want help choosing the right iterator.
