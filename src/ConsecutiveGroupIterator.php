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
 * Class ConsecutiveGroupIterator.
 *
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
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class ConsecutiveGroupIterator extends \IteratorIterator
{
    /**
     * @var \Closure the callback function that determines when to start a new chunk
     */
    private \Closure $callback;

    /**
     * @var array<int, mixed> the buffer storing the current chunk of elements
     */
    private array $buffer = [];

    /**
     * Initializes the ConsecutiveGroupIterator.
     *
     * @param \Traversable $iterator the iterator containing values to be chunked
     * @param \Closure     $callback The function that determines whether elements should be in the same chunk.
     *                               It receives two arguments: `$previous` and `$current`,
     *                               and must return `true` to keep them together or `false` to start a new chunk.
     */
    public function __construct(\Traversable $iterator, \Closure $callback)
    {
        parent::__construct($iterator);
        $this->callback = $callback;
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
     * Advances to the next chunk of elements.
     */
    public function next(): void
    {
        $this->buffer = [];

        while (parent::valid()) {
            $currentValue = parent::current();

            if (!empty($this->buffer)
                && !($this->callback)($this->buffer[\count($this->buffer) - 1], $currentValue)) {
                break;
            }

            $this->buffer[] = $currentValue;
            parent::next();
        }
    }

    /**
     * Checks if the current chunk contains valid elements.
     *
     * @return bool true if a chunk exists, false otherwise
     */
    public function valid(): bool
    {
        return !empty($this->buffer);
    }

    /**
     * Resets the iterator and prepares the first chunk.
     */
    public function rewind(): void
    {
        parent::rewind();
        $this->next();
    }
}
