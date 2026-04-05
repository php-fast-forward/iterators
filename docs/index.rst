Documentation
=============

Fast Forward Iterators is a focused toolkit for building lazy, composable, and
countable iteration pipelines in PHP. It helps you chunk data, group values,
peek ahead, replay generators, combine multiple sources, and normalize
different iterable inputs behind a consistent API.

This documentation is written for both audiences that usually meet in the same
codebase:

- developers who want a safe first path through the package;
- experienced users who need a quick reference for edge cases and extension
  points.

Useful links
------------

- `GitHub repository <https://github.com/php-fast-forward/iterators>`_
- `Issue tracker <https://github.com/php-fast-forward/iterators/issues>`_
- `Packagist package <https://packagist.org/packages/fast-forward/iterators>`_
- `Examples directory <https://github.com/php-fast-forward/iterators/tree/main/examples>`_

What this package is good at
----------------------------

- breaking large iterables into smaller pieces with chunking and sliding
  windows;
- transforming, trimming, filtering, and deduplicating values lazily;
- combining multiple sources sequentially, round-robin, or in lockstep;
- making generators reusable when your workflow needs more than one pass;
- providing reusable countable base classes for your own iterator abstractions.

.. toctree::
   :maxdepth: 2
   :caption: Contents

   getting-started/index
   usage/index
   api/index
   advanced/index
   links/index
   faq
   compatibility
