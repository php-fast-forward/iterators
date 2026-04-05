Foundations and Extension Points
================================

Most users only instantiate the concrete iterators documented elsewhere.
However, this package also exposes a small set of base abstractions that make
custom iterator code easier to write and count correctly.

Foundation classes
------------------

.. list-table:: Public building blocks
   :header-rows: 1
   :widths: 24 36 40

   * - Class
     - Use it when...
     - Notes
   * - ``IterableIterator``
     - you want to accept any iterable and normalize it to an ``Iterator``
     - arrays become ``ArrayIterator`` automatically; existing ``Traversable``
       objects are wrapped as needed
   * - ``CountableIterator``
     - you are implementing the full iterator lifecycle yourself
     - extends ``Iterator`` plus ``Countable`` semantics
   * - ``CountableIteratorAggregate``
     - your object can expose iteration through ``getIterator()``
     - usually the simplest base class for custom iterator aggregates
   * - ``CountableIteratorIterator``
     - you want to decorate an existing iterator and tweak its behavior
     - ideal for wrappers that transform the current value or key
   * - ``CountableFilterIterator``
     - you want to implement ``accept()``-based filtering
     - useful for filesystem-style filters or rule-based filtering wrappers

How counting works
------------------

The countable base classes share a consistent goal: calling ``count()`` should
reflect the visible sequence without forcing every consumer to materialize the
iterator manually.

In practice:

- if the wrapped iterator already implements ``Countable``, that implementation
  is reused;
- otherwise the package counts by iterating over a clone when possible;
- if cloning is not possible, the wrapper counts by traversing a safe adapter.

This behavior is implemented by ``CountableIteratorIteratorTrait``. You normally
do not need to interact with the trait directly, but it explains why the base
classes exist and why they are worth reusing.

Which base class should you extend?
-----------------------------------

- Extend ``CountableIteratorAggregate`` when your class can simply ``yield``
  values or return another traversable object.
- Extend ``CountableIteratorIterator`` when your class mostly delegates to an
  inner iterator but customizes ``current()``, ``key()``, ``next()``, or
  ``rewind()``.
- Extend ``CountableFilterIterator`` when a boolean ``accept()`` rule is the
  main customization point.
- Extend ``CountableIterator`` only when you truly need full control over
  iterator state and navigation.

Minimal custom aggregate
------------------------

If your logic can be expressed as a generator, ``CountableIteratorAggregate`` is
usually the least error-prone option:

.. code-block:: php

   use FastForward\Iterator\CountableIteratorAggregate;

   final class EvenNumbers extends CountableIteratorAggregate
   {
       public function __construct(private readonly iterable $values)
       {
       }

       public function getIterator(): Traversable
       {
           foreach ($this->values as $value) {
               if ($value % 2 === 0) {
                   yield $value;
               }
           }
       }
   }

Minimal filter wrapper
----------------------

Use ``CountableFilterIterator`` when your iterator already fits the SPL filter
pattern:

.. code-block:: php

   use FastForward\Iterator\CountableFilterIterator;

   final class PositiveOnlyIterator extends CountableFilterIterator
   {
       public function accept(): bool
       {
           return $this->current() > 0;
       }
   }
