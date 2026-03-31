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

use ReflectionClass;
use Countable;
use IteratorIterator;

trait CountableIteratorIteratorTrait
{
    /**
     * Counts the number of elements in the iterable.
     *
     * If the inner iterator implements Countable, it uses that. Otherwise, it
     * counts the elements by iterating through them.
     *
     * @return int the number of elements in the iterable
     */
    public function count(): int
    {
        $inner = $this->getInnerIterator();

        if ($inner instanceof Countable) {
            return $inner->count();
        }

        $isCloneable = (new ReflectionClass($inner))->isCloneable();

        if (! $isCloneable) {
            return iterator_count(new IteratorIterator($this));
        }

        return iterator_count(clone $inner);
    }
}
