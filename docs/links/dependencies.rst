Dependencies
============

Runtime requirements
--------------------

.. list-table:: Direct runtime requirements
   :header-rows: 1
   :widths: 28 20 52

   * - Dependency
     - Type
     - Notes
   * - ``php``
     - required
     - the package requires PHP 8.3 or newer
   * - SPL iterator classes
     - built in
     - classes such as ``ArrayIterator``, ``IteratorIterator``,
       ``FilterIterator``, ``LimitIterator``, and ``FilesystemIterator`` are
       used heavily throughout the package
   * - ``ext-mbstring``
     - recommended for string-centric workflows
     - code paths used by ``TrimIteratorIterator``,
       ``FileExtensionFilterIterator``, and case-insensitive
       ``UniqueIteratorIterator`` call ``mb_*`` helpers

Development dependencies
------------------------

.. list-table:: Composer development requirements
   :header-rows: 1
   :widths: 28 72

   * - Package
     - Purpose
   * - ``fast-forward/dev-tools``
     - project-level quality tooling used during development and CI

External references
-------------------

- `PHP manual: iterators <https://www.php.net/manual/en/language.iterators.php>`_
- `PHP manual: generators <https://www.php.net/manual/en/language.generators.overview.php>`_
- `PHP manual: Countable <https://www.php.net/manual/en/class.countable.php>`_
- `PHP manual: ArrayIterator <https://www.php.net/manual/en/class.arrayiterator.php>`_
- `PHP manual: FilesystemIterator <https://www.php.net/manual/en/class.filesystemiterator.php>`_
