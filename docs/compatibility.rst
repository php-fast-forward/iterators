Compatibility
=============

Version support
---------------

.. list-table:: Supported runtime targets
   :header-rows: 1
   :widths: 32 68

   * - Topic
     - Status
   * - PHP
     - PHP 8.3 or newer
   * - Runtime Composer dependencies
     - none beyond PHP itself
   * - Iterator ecosystem
     - built around native PHP ``iterable``, ``Iterator``, ``IteratorAggregate``,
       ``FilterIterator``, ``LimitIterator``, and related SPL components

Behavioral compatibility notes
------------------------------

- The package is designed around native PHP iterator semantics, not PSR
  interfaces.
- Public iterators intentionally accept plain arrays as well as traversable
  objects.
- Many classes are ``Countable``. For wrapper-style iterators, the count is
  derived from the visible sequence rather than from a separate metadata source.
- String-oriented helpers rely on ``mb_*`` functions, so environments using
  those features should have ``ext-mbstring`` available.

Upgrade expectations
--------------------

When upgrading within the same major version, the safest assumptions are:

- constructors keep accepting ordinary PHP iterables;
- iterator output remains lazy unless a class explicitly groups or caches values;
- extension points continue to be the public countable base classes documented
  in :doc:`api/foundations`.
