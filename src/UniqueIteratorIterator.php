<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/iterators.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/php-fast-forward/iterators
 * @copyright Copyright (c) 2025 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace FastForward\Iterator;

/**
 * Class UniqueIteratorIterator.
 *
 * Filters duplicate values from an iterator, ensuring uniqueness.
 *
 * This iterator allows traversing an iterable while maintaining a record of seen values,
 * returning only the first occurrence of each unique value. Subsequent occurrences are skipped.
 *
 * ## Usage Example:
 *
 * @example Removing duplicate values
 * ```php
 * use FastForward\Iterator\UniqueIteratorIterator;
 * use ArrayIterator;
 *
 * $data = new ArrayIterator([1, 2, 2, 3, 4, 4, 5]);
 * $uniqueIterator = new UniqueIteratorIterator($data);
 *
 * foreach ($uniqueIterator as $num) {
 *     echo $num . ' '; // Outputs: 1 2 3 4 5
 * }
 * ```
 * @example Case-insensitive uniqueness
 * ```php
 * use FastForward\Iterator\UniqueIteratorIterator;
 * use ArrayIterator;
 *
 * $data = new ArrayIterator(['a', 'A', 'b', 'B', 'a']);
 * $uniqueIterator = new UniqueIteratorIterator($data, false);
 *
 * foreach ($uniqueIterator as $char) {
 *     echo $char . ' '; // Outputs: a A b B a (case-sensitive comparison disabled)
 * }
 * ```
 *
 * **Note:** This iterator preserves the order of first occurrences.
 *
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class UniqueIteratorIterator extends \IteratorIterator
{
    /**
     * @var array<int|string, mixed> stores seen values to ensure uniqueness
     */
    private array $seen = [];

    /**
     * @var bool whether to use strict comparison when checking for uniqueness
     */
    private bool $strict;

    /**
     * Initializes the UniqueIteratorIterator.
     *
     * @param \Traversable $iterator the iterator to filter for unique values
     * @param bool         $strict   whether to use strict comparison (default: true)
     */
    public function __construct(\Traversable $iterator, bool $strict = true)
    {
        parent::__construct($iterator);
        $this->strict = $strict;
    }

    /**
     * Retrieves the current unique element.
     *
     * @return mixed the current unique value
     */
    public function current(): mixed
    {
        return parent::current();
    }

    /**
     * Determines whether the current position is valid.
     *
     * This method skips values that have already been encountered.
     *
     * @return bool true if a unique value is available, false otherwise
     */
    public function valid(): bool
    {
        while (parent::valid()) {
            $value = parent::current();

            if (!\in_array($value, $this->seen, $this->strict)) {
                $this->seen[] = $value;

                return true;
            }

            parent::next();
        }

        return false;
    }

    /**
     * Resets the iterator and clears the seen values.
     */
    public function rewind(): void
    {
        parent::rewind();
        $this->seen = [];
    }
}
