FAQ
===

What package name should I install?
-----------------------------------

Install ``fast-forward/iterators``:

.. code-block:: bash

   composer require fast-forward/iterators

The package name should match the value declared in ``composer.json``.

Which class should I try first?
-------------------------------

Start with ``ChunkedIteratorAggregate`` if you need batches,
``SlidingWindowIteratorIterator`` if you need overlapping groups, or
``ClosureIteratorIterator`` if you simply want to transform values lazily.

Do I need to wrap arrays in ``ArrayIterator`` first?
----------------------------------------------------

No. Most public classes accept plain arrays directly. Internally, the package
uses ``IterableIterator`` to normalize arrays and traversables into consistent
iterators.

Why are some keys renumbered?
-----------------------------

Several iterators intentionally expose normalized sequential keys because the
original key layout no longer makes sense after combination or filtering.

Examples:

- ``ChainIterableIterator`` exposes sequential numeric positions;
- ``UniqueIteratorIterator`` exposes the position of each unique value;
- ``SlidingWindowIteratorIterator`` exposes the position of each window.

Why does ``ZipIteratorIterator`` stop before the longest input ends?
--------------------------------------------------------------------

Because zip semantics are lockstep semantics. A row can only be produced while
every input still has a current value, so the shortest iterable defines the
maximum output length.

Why did ``SlidingWindowIteratorIterator`` return no values?
-----------------------------------------------------------

That happens when the input contains fewer elements than the window size. A
window is only valid when it is completely full.

What is the difference between ``GroupByIteratorIterator`` and ``ConsecutiveGroupIterator``?
---------------------------------------------------------------------------------------------

``GroupByIteratorIterator`` groups all matching values across the entire input.
``ConsecutiveGroupIterator`` only groups neighbors while a callback keeps
returning ``true``.

How do I reuse a generator across multiple loops?
-------------------------------------------------

Use ``GeneratorRewindableIterator`` when you want a direct iterator, or
``GeneratorCachingIteratorAggregate`` when an aggregate-style wrapper fits your
API better. Both strategies cache generated values so you can iterate again.

How do I inspect what an iterator is producing?
-----------------------------------------------

Use ``debugIterable()`` during development. It prints a section header, the
count, and each visible key-value pair in a readable format.

Can my closure see iterator keys?
---------------------------------

Yes. ``ClosureIteratorIterator`` calls your closure with both the current value
and the current key, so you can transform based on either.

Does ``count()`` consume my iterator?
-------------------------------------

The package is designed so that countable wrappers count safely whenever
possible. The exact strategy depends on the wrapped iterator, which is why the
base classes in :doc:`api/foundations` are worth reusing in custom code.

Can I build my own iterators on top of this package?
----------------------------------------------------

Yes. The recommended starting points are ``CountableIteratorAggregate``,
``CountableIteratorIterator``, ``CountableFilterIterator``, and
``CountableIterator``. The :doc:`advanced/extending` page explains when to use
each one.

Do I need a framework or container integration?
-----------------------------------------------

No. This package is framework-agnostic. Instantiate the iterators directly, or
register them in your own container exactly like any other PHP object.
