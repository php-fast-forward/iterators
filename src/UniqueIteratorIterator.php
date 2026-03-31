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

/**
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
 * @since 1.0.0
 */
class UniqueIteratorIterator extends CountableIteratorIterator
{
    /**
     * @var array<int|string, mixed> stores seen values to ensure uniqueness
     */
    private array $seen = [];

    /**
     * @var int the current position for the unique elements
     */
    private int $position = 0;

    /**
     * Initializes the UniqueIteratorIterator.
     *
     * @param iterable $iterator the iterator to filter for unique values
     * @param bool $strict whether to use strict comparison (default: true)
     * @param bool $caseSensitive whether to use case-sensitive comparison (default: true)
     */
    public function __construct(
        iterable $iterator,
        private readonly bool $strict = true,
        private readonly bool $caseSensitive = true,
    ) {
        parent::__construct(new IterableIterator($iterator));
    }

    /**
     * Retrieves the normalized sequential key for the current unique element.
     *
     * @return int the zero-based position of the current unique value
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Advances to the next unique element.
     *
     * @return void
     */
    public function next(): void
    {
        parent::next();
        $this->skipDuplicates();

        if (parent::valid()) {
            ++$this->position;
        }
    }

    /**
     * Resets the iterator and clears the seen values.
     *
     * @return void
     */
    public function rewind(): void
    {
        parent::rewind();
        $this->seen = [];
        $this->position = 0;
        $this->skipDuplicates();
    }

    /**
     * Skips values that have already been encountered and stores the current unique value.
     *
     * @return void
     */
    private function skipDuplicates(): void
    {
        while (parent::valid()) {
            $value = parent::current();

            if (! $this->caseSensitive && \is_string($value)) {
                $value = mb_strtolower($value);
            }

            if (! \in_array($value, $this->seen, $this->strict)) {
                $this->seen[] = $value;

                return;
            }

            parent::next();
        }
    }
}
