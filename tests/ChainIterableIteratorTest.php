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
use FastForward\Iterator\ChainIterableIterator;
use FastForward\Iterator\IterableIterator;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(ChainIterableIterator::class)]
#[UsesClass(IterableIterator::class)]
final class ChainIterableIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function foreachWithSingleArrayWillReturnAllElements(): void
    {
        $it = new ChainIterableIterator([1, 2, 3]);
        $result = iterator_to_array($it, false);
        self::assertSame([1, 2, 3], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithMultipleArraysWillChainAllElements(): void
    {
        $it = new ChainIterableIterator([1, 2], [3, 4]);
        $result = iterator_to_array($it, false);
        self::assertSame([1, 2, 3, 4], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithEmptyArraysWillReturnEmpty(): void
    {
        $it = new ChainIterableIterator([], []);
        $result = iterator_to_array($it, false);
        self::assertSame([], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function rewindWillResetToFirstElement(): void
    {
        $it = new ChainIterableIterator([1, 2], [3]);
        $it->next(); // Avança para o segundo elemento
        $it->rewind();
        self::assertSame(1, $it->current());
    }

    /**
     * @return void
     */
    #[Test]
    public function keyWillReturnSequentialPosition(): void
    {
        $it = new ChainIterableIterator([10, 20], [30]);
        $keys = [];
        foreach ($it as $key => $value) {
            $keys[] = $key;
        }

        self::assertSame([0, 1, 2], $keys);
    }

    /**
     * @return void
     */
    #[Test]
    public function countWillReturnTotalElements(): void
    {
        $it = new ChainIterableIterator([1, 2], [3, 4, 5]);
        self::assertSame(5, $it->count());
    }

    /**
     * @return void
     */
    #[Test]
    public function validWithEmptyIterablesWillReturnFalse(): void
    {
        $it = new ChainIterableIterator([], []);
        self::assertFalse($it->valid());
    }

    /**
     * @return void
     */
    #[Test]
    public function currentWithNoValidElementWillReturnNull(): void
    {
        $it = new ChainIterableIterator([]);
        self::assertNull($it->current());
    }

    /**
     * @return void
     */
    #[Test]
    public function keyWithNoValidElementWillReturnNull(): void
    {
        $it = new ChainIterableIterator([]);
        self::assertNull($it->key());
    }

    /**
     * @return void
     */
    #[Test]
    public function nextWithNoValidElementWillDoNothing(): void
    {
        $it = new ChainIterableIterator([]);
        $it->next();
        self::assertNull($it->current());
    }

    /**
     * @return void
     */
    #[Test]
    public function countReturnsTotalElementsForSingleArray(): void
    {
        $it = new ChainIterableIterator([1, 2, 3]);
        self::assertSame(3, count($it));
    }

    /**
     * @return void
     */
    #[Test]
    public function countReturnsTotalElementsForMultipleArrays(): void
    {
        $it = new ChainIterableIterator([1, 2], [3, 4, 5]);
        self::assertSame(5, count($it));
    }

    /**
     * @return void
     */
    #[Test]
    public function countReturnsZeroForEmptyIterables(): void
    {
        $it = new ChainIterableIterator([], []);
        self::assertSame(0, count($it));
    }
}
