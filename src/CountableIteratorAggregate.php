<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/iterators.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @copyright Copyright (c) 2025-2026 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 *
 * @see       https://github.com/php-fast-forward/iterators
 * @see       https://github.com/php-fast-forward
 * @see       https://datatracker.ietf.org/doc/html/rfc2119
 */

namespace FastForward\Iterator;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Provides a base implementation for iterator aggregate objects that are also countable.
 *
 * This abstract class SHALL serve as a reusable foundation for concrete iterator aggregate
 * implementations that expose a traversable iterator and require count-related behavior.
 * Implementations MUST provide a valid iterator through {@see getIterator()}, and that
 * iterator SHOULD be suitable for reuse by the count-related logic provided through the
 * composed trait.
 */
abstract class CountableIteratorAggregate implements IteratorAggregate, Countable
{
    use CountableIteratorIteratorTrait;

    /**
     * Returns the inner traversable iterator used by the aggregate.
     *
     * This method SHALL proxy the iterator returned by {@see getIterator()} without altering
     * its semantics or traversal behavior. Consumers of this method MUST receive the same
     * traversable instance or equivalent traversable representation exposed by the aggregate.
     * This method SHOULD remain private because it exists only to support the internal
     * collaboration between this class and its trait-based behavior.
     *
     * @return Traversable the traversable iterator exposed by the aggregate implementation
     */
    private function getInnerIterator(): Traversable
    {
        return $this->getIterator();
    }
}
