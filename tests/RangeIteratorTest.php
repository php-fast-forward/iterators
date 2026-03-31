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
use FastForward\Iterator\RangeIterator;

#[CoversClass(RangeIterator::class)]
final class RangeIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function integerRangeAscendingWorks(): void
    {
        $it = new RangeIterator(1, 5);
        $result = iterator_to_array($it, false);
        self::assertSame([1, 2, 3, 4, 5], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function integerRangeDescendingWorks(): void
    {
        $it = new RangeIterator(5, 1);
        $result = iterator_to_array($it, false);
        self::assertSame([5, 4, 3, 2, 1], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function integerRangeWithStepWorks(): void
    {
        $it = new RangeIterator(1, 10, 2);
        $result = iterator_to_array($it, false);
        self::assertSame([1, 3, 5, 7, 9], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function floatRangeWorks(): void
    {
        $it = new RangeIterator(0.5, 2.5, 0.5);
        $result = iterator_to_array($it, false);
        self::assertEqualsWithDelta([0.5, 1.0, 1.5, 2.0, 2.5], $result, 1e-10);
    }

    /**
     * @return void
     */
    #[Test]
    public function floatRangeWithIncludeBoundaryWorks(): void
    {
        $it = new RangeIterator(0, 5, 1.5, true);
        $result = iterator_to_array($it, false);
        self::assertEqualsWithDelta([0, 1.5, 3.0, 4.5, 5.0], $result, 1e-10);
    }

    /**
     * @return void
     */
    #[Test]
    public function countReturnsCorrectNumberOfSteps(): void
    {
        $it = new RangeIterator(1, 5);
        self::assertSame(5, $it->count());
        $it2 = new RangeIterator(0, 5, 2);
        self::assertSame(3, $it2->count());
        $it3 = new RangeIterator(0, 5, 1.5, true);
        self::assertSame(5, $it3->count());
    }

    /**
     * @return void
     */
    #[Test]
    public function keyReturnsCurrentIndex(): void
    {
        $it = new RangeIterator(1, 3);
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
    public function rewindResetsIterator(): void
    {
        $it = new RangeIterator(1, 3);
        $it->next();
        $it->rewind();
        self::assertSame(1, $it->current());
        self::assertSame(0, $it->key());
    }

    /**
     * @return void
     */
    #[Test]
    public function throwsIfStepIsZeroOrNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new RangeIterator(1, 5, 0);
    }

    /**
     * @return void
     */
    #[Test]
    public function throwsIfStepIsGreaterThanRange(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new RangeIterator(1, 5, 10);
    }

    /**
     * @return void
     */
    #[Test]
    public function singleElementRangeWorks(): void
    {
        $it = new RangeIterator(2, 2);
        $result = iterator_to_array($it, false);
        self::assertSame([2], $result);
        self::assertSame(1, $it->count());
    }
}
