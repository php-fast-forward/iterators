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
use FilterIterator;

/**
 * Provides a filter iterator implementation that is also countable.
 *
 * This abstract class SHALL extend {@see FilterIterator} so that concrete
 * implementations MAY filter elements from an inner iterator while also
 * exposing count semantics. The counting behavior MUST be provided through
 * the composed trait and SHALL operate according to the characteristics of
 * the wrapped inner iterator. Implementations SHOULD ensure that their
 * filtering logic remains consistent with the sequence being counted.
 */
abstract class CountableFilterIterator extends FilterIterator implements Countable
{
    use CountableIteratorIteratorTrait;
}
