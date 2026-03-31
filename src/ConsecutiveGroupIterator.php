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
 * Groups elements dynamically based on a user-defined condition.
 *
 * This iterator chunks elements from a traversable source, creating groups where
 * each new element is added to the current chunk until the provided callback
 * returns `false`, signaling the start of a new chunk.
 *
 * ## Usage Example:
 *
 * @example Grouping consecutive equal elements
 * ```php
 * use FastForward\Iterator\ConsecutiveGroupIterator;
 * use ArrayIterator;
 *
 * $data = new ArrayIterator([1, 1, 2, 2, 2, 3, 4, 4, 5]);
 *
 * $chunkedIterator = new ConsecutiveGroupIterator($data, fn($prev, $curr) => $prev === $curr);
 *
 * foreach ($chunkedIterator as $chunk) {
 *     print_r($chunk);
 * }
 * // Outputs:
 * // [1, 1]
 * // [2, 2, 2]
 * // [3]
 * // [4, 4]
 * // [5]
 * ```
 *
 * **Note:** The chunking behavior is defined by the callback function.
 *
 * @since 1.0.0
 */
class ConsecutiveGroupIterator extends CountableIteratorIterator
{
    /**
     * @var array<int, mixed> the buffer storing the current chunk of elements
     */
    private array $buffer = [];

    /**
     * @var int the current group key for the iterator
     */
    private int $groupKey = 0;

    /**
     * Initializes the ConsecutiveGroupIterator.
     *
     * @param iterable $iterator the iterator containing values to be chunked
     * @param Closure $callback The function that determines whether elements should be in the same chunk.
     *                          It receives two arguments: `$previous` and `$current`,
     *                          and must return `true` to keep them together or `false` to start a new chunk.
     */
    public function __construct(
        iterable $iterator,
        private readonly Closure $callback
    ) {
        parent::__construct(new IterableIterator($iterator));
    }

    /**
     * Retrieves the current chunk of elements.
     *
     * @return array<int, mixed> the current chunk as an array
     */
    public function current(): array
    {
        return $this->buffer;
    }

    /**
     * Retrieves the current group key.
     *
     * @return int|null the current group key, or null if the iterator is not valid
     */
    public function key(): ?int
    {
        return $this->valid() ? $this->groupKey : null;
    }

    /**
     * Advances to the next chunk of elements.
     *
     * @return void
     */
    public function next(): void
    {
        if ($this->loadChunk()) {
            ++$this->groupKey;
        }
    }

    /**
     * Checks if the current chunk contains valid elements.
     *
     * @return bool true if a chunk exists, false otherwise
     */
    public function valid(): bool
    {
        return [] !== $this->buffer;
    }

    /**
     * Resets the iterator and prepares the first chunk.
     *
     * @return void
     */
    public function rewind(): void
    {
        parent::rewind();
        $this->loadChunk();
        $this->groupKey = 0;
    }

    /**
     * Loads the next chunk of elements based on the callback condition.
     *
     * This method fills the buffer with consecutive elements that satisfy the callback condition.
     *
     * @return bool true if a chunk was loaded, false otherwise
     */
    private function loadChunk(): bool
    {
        $this->buffer = [];

        while (parent::valid()) {
            $currentValue = parent::current();

            if ([] !== $this->buffer) {
                $lastValue = $this->buffer[array_key_last($this->buffer)];

                if (! ($this->callback)($lastValue, $currentValue)) {
                    break;
                }
            }

            $this->buffer[] = $currentValue;
            parent::next();
        }

        return [] !== $this->buffer;
    }
}
