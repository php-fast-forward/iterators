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
 * Class ChunkedIteratorAggregate.
 *
 * Splits an iterable into fixed-size chunks.
 *
 * This iterator wraps a `Traversable` and groups elements into subarrays
 * of a fixed size. If the total number of elements is not a multiple of
 * the chunk size, the last chunk may contain fewer elements.
 *
 * ## Usage Example:
 *
 * @example Using ChunkedIteratorAggregate
 * ```php
 * use FastForward\Iterator\ChunkedIteratorAggregate;
 *
 * $chunks = new ChunkedIteratorAggregate(range(1, 10), 3);
 *
 * foreach ($chunks as $chunk) {
 *     print_r($chunk);
 * }
 * // Outputs:
 * // [1, 2, 3]
 * // [4, 5, 6]
 * // [7, 8, 9]
 * // [10]
 * ```
 *
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class ChunkedIteratorAggregate implements \IteratorAggregate
{
    /**
     * @var iterable the iterator being chunked
     */
    private iterable $iterator;

    /**
     * @var int the size of each chunk
     */
    private int $chunkSize;

    /**
     * Initializes the ChunkedIteratorAggregate.
     *
     * @param iterable $iterator  the iterator containing values to be chunked
     * @param int      $chunkSize the number of elements per chunk (must be >= 1)
     */
    public function __construct(iterable $iterator, int $chunkSize)
    {
        $this->iterator  = $iterator;
        $this->chunkSize = max(1, $chunkSize);
    }

    /**
     * Retrieves an iterator that yields arrays containing elements in chunks.
     *
     * The iteration groups elements from the original iterator into
     * subarrays of `$chunkSize` elements each.
     *
     * @return \Traversable<int, array<int, mixed>> the iterator yielding chunked arrays
     */
    public function getIterator(): \Traversable
    {
        $buffer = [];
        foreach ($this->iterator as $value) {
            $buffer[] = $value;
            if (\count($buffer) === $this->chunkSize) {
                yield $buffer;
                $buffer = [];
            }
        }

        if ($buffer) {
            yield $buffer;
        }
    }
}
