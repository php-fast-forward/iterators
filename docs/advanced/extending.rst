Extending the Library
=====================

Fast Forward Iterators does not require a container, a framework integration, or
package-specific service registration. Extension is intentionally simple: build
on top of the public iterator base classes and pass around ordinary PHP
iterables.

Recommended extension workflow
------------------------------

1. accept ``iterable`` as input whenever possible;
2. normalize it with ``IterableIterator`` if you need a consistent ``Iterator``;
3. choose the smallest countable base class that matches your design;
4. keep the output shape obvious in both naming and documentation.

Choosing the right base class
-----------------------------

.. list-table:: Extension guide
   :header-rows: 1
   :widths: 26 34 40

   * - Base class
     - Best for
     - Example ideas
   * - ``CountableIteratorAggregate``
     - generator-based or delegated iteration
     - chunking, mapping, flattening, lazy adapters
   * - ``CountableIteratorIterator``
     - wrappers around an existing iterator
     - transforming values, remapping keys, peeking helpers
   * - ``CountableFilterIterator``
     - boolean acceptance rules
     - path filters, record filters, validation gates
   * - ``CountableIterator``
     - full stateful control
     - custom navigation, multi-source coordination, specialized range logic

Practical advice
----------------

- Prefer aggregates when you can express the behavior with ``yield``.
- Prefer wrappers when you want to preserve most behavior of an inner iterator.
- Document whether your iterator preserves original keys or emits normalized
  sequential keys.
- Call out whether a class buffers values in memory. This matters for
  ``LookaheadIterator``, grouping iterators, and generator replay strategies.

No hidden framework hooks
-------------------------

This package does not expose:

- aliases;
- singletons;
- framework-specific service providers;
- PSR-11 container bindings.

That keeps custom integration straightforward: instantiate the iterator directly
where you need it, or register it in your own application container using normal
PHP construction rules.
