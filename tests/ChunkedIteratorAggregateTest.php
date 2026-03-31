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

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use FastForward\Iterator\ChunkedIteratorAggregate;
use FastForward\Iterator\CountableIteratorIteratorTrait;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(ChunkedIteratorAggregate::class)]
#[UsesTrait(CountableIteratorIteratorTrait::class)]
final class ChunkedIteratorAggregateTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function getIteratorWithArrayWillChunkCorrectly(): void
    {
        $agg = new ChunkedIteratorAggregate([1, 2, 3, 4, 5], 2);
        $result = iterator_to_array($agg);
        self::assertSame([[1, 2], [3, 4], [5]], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function getIteratorWithChunkSizeLargerThanArrayWillReturnSingleChunk(): void
    {
        $agg = new ChunkedIteratorAggregate([1, 2], 10);
        $result = iterator_to_array($agg);
        self::assertSame([[1, 2]], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function getIteratorWithEmptyArrayWillReturnEmpty(): void
    {
        $agg = new ChunkedIteratorAggregate([], 3);
        $result = iterator_to_array($agg);
        self::assertSame([], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function getIteratorWithChunkSizeOneWillReturnSingleElements(): void
    {
        $agg = new ChunkedIteratorAggregate([1, 2, 3], 1);
        $result = iterator_to_array($agg);
        self::assertSame([[1], [2], [3]], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function countReturnsTotalElementsForSingleArray(): void
    {
        $it = new ChunkedIteratorAggregate([1, 2, 3], 1);
        self::assertSame(3, count($it));
    }

    /**
     * @return void
     */
    #[Test]
    public function countReturnsTotalElementsForMultipleArrays(): void
    {
        $it = new ChunkedIteratorAggregate([1, 2], 1);
        self::assertSame(2, count($it));
    }

    /**
     * @return void
     */
    #[Test]
    public function countReturnsZeroForEmptyIterables(): void
    {
        $it = new ChunkedIteratorAggregate([], 1);
        self::assertSame(0, count($it));
    }
}
