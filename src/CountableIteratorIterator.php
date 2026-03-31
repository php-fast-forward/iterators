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
use IteratorIterator;

/**
 * Provides an iterator wrapper that is also countable.
 *
 * This class SHALL extend {@see IteratorIterator} to decorate an existing iterator while
 * exposing counting behavior through the composed trait. The wrapped iterator MUST be
 * compatible with the expectations of {@see IteratorIterator}, and consumers SHOULD rely
 * on this class when they need both traversal and count semantics from a single object.
 */
class CountableIteratorIterator extends IteratorIterator implements Countable
{
    use CountableIteratorIteratorTrait;
}
