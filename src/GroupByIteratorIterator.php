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

use Closure;

/**
 * Class GroupByIteratorIterator.
 *
 * Groups elements from an iterator based on a callback function.
 *
 * This iterator aggregates elements into associative arrays where the keys are
 * determined by a user-defined function (`$groupBy`). Each key contains an array
 * of elements that share the same computed group.
 *
 * ## Usage Example:
 *
 * @example Grouping by age
 * ```php
 * use FastForward\Iterator\GroupByIteratorIterator;
 * use ArrayIterator;
 *
 * $data = new ArrayIterator([
 *     ['name' => 'Alice', 'age' => 25],
 *     ['name' => 'Bob', 'age' => 30],
 *     ['name' => 'Charlie', 'age' => 25],
 * ]);
 *
 * $grouped = new GroupByIteratorIterator($data, fn($item) => $item['age']);
 *
 * foreach ($grouped as $age => $group) {
 *     echo "Age: $age\n";
 *     print_r($group);
 * }
 * // Outputs:
 * // Age: 25
 * // [['name' => 'Alice', 'age' => 25], ['name' => 'Charlie', 'age' => 25]]
 * // Age: 30
 * // [['name' => 'Bob', 'age' => 30]]
 * ```
 *
 * **Note:** The iterator must be rewound before iterating again to ensure correct grouping.
 *
 * @since 1.0.0
 */
class GroupByIteratorIterator extends CountableIteratorIterator
{
    /**
     * @var array<mixed, array<int, mixed>> holds grouped elements
     */
    private array $groups = [];

    /**
     * Initializes the GroupByIteratorIterator.
     *
     * @param iterable $iterator the iterator containing values to be grouped
     * @param Closure $groupBy a function that determines the group key for each element
     */
    public function __construct(
        iterable $iterator,
        private readonly Closure $groupBy
    ) {
        parent::__construct(new IterableIterator($iterator));
    }

    /**
     * Rewinds the iterator and reprocesses the grouping.
     *
     * This ensures that the grouping is correctly recomputed when the iterator is reset.
     *
     * @return void
     */
    public function rewind(): void
    {
        parent::rewind();
        $this->groups = [];

        foreach ($this->getInnerIterator() as $key => $value) {
            $groupKey                  = ($this->groupBy)($value, $key);
            $this->groups[$groupKey][] = $value;
        }

        reset($this->groups);
    }

    /**
     * Retrieves the current group of elements.
     *
     * @return array<int, mixed> the current group of elements
     */
    public function current(): array
    {
        return current($this->groups);
    }

    /**
     * Retrieves the key of the current group.
     *
     * @return mixed the computed key representing the current group
     */
    public function key(): mixed
    {
        return key($this->groups);
    }

    /**
     * Advances to the next group in the iterator.
     *
     * @return void
     */
    public function next(): void
    {
        next($this->groups);
    }

    /**
     * Checks if the current position is valid.
     *
     * @return bool true if a valid group exists, false otherwise
     */
    public function valid(): bool
    {
        return null !== key($this->groups);
    }
}
