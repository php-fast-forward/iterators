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

use FastForward\Iterator\IterableIterator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use FastForward\Iterator\ZipIteratorIterator;

#[CoversClass(ZipIteratorIterator::class)]
#[CoversClass(IterableIterator::class)]
final class ZipIteratorIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function constructWithTwoArraysWillZipCorrectly(): void
    {
        $it = new ZipIteratorIterator([1, 2, 3], ['A', 'B', 'C']);
        $result = iterator_to_array($it);
        self::assertSame([[1, 'A'], [2, 'B'], [3, 'C']], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function constructWithDifferentLengthWillStopAtShortest(): void
    {
        $it = new ZipIteratorIterator([1, 2], ['A', 'B', 'C']);
        $result = iterator_to_array($it);
        self::assertSame([[1, 'A'], [2, 'B']], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function keyWithMultipleIterationsWillReturnCurrentIndex(): void
    {
        $it = new ZipIteratorIterator([1, 2], ['A', 'B']);
        $it->rewind();
        self::assertSame(0, $it->key());
        $it->next();
        self::assertSame(1, $it->key());
    }

    /**
     * @return void
     */
    #[Test]
    public function validWithExhaustedIteratorWillReturnFalse(): void
    {
        $it = new ZipIteratorIterator([], ['A', 'B']);
        $it->rewind();
        self::assertFalse($it->valid());
    }

    /**
     * @return void
     */
    #[Test]
    public function constructWithLessThanTwoIteratorsWillThrow(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new ZipIteratorIterator([1, 2]);
    }
}
