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
use FastForward\Iterator\InterleaveIteratorIterator;
use FastForward\Iterator\IterableIterator;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(InterleaveIteratorIterator::class)]
#[UsesClass(IterableIterator::class)]
final class InterleaveIteratorIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function keyReturnsStringKeyIfPresent(): void
    {
        $it = new InterleaveIteratorIterator([
            'a' => 1,
            'b' => 2,
        ], [
            'x' => 3,
            'y' => 4,
        ]);
        $keys = [];
        foreach ($it as $key => $value) {
            $keys[] = $key;
        }

        self::assertSame(['a', 'x', 'b', 'y'], $keys);
    }

    /**
     * @return void
     */
    #[Test]
    public function keyReturnsSequentialForNumericKeys(): void
    {
        $it = new InterleaveIteratorIterator([10, 20], [30, 40]);
        $keys = [];
        foreach ($it as $key => $value) {
            $keys[] = $key;
        }

        self::assertSame([0, 1, 2, 3], $keys);
    }

    /**
     * @return void
     */
    #[Test]
    public function nextAdvancesPositionOnlyForNumericKeys(): void
    {
        $it = new InterleaveIteratorIterator([
            'a' => 1,
            2,
        ], [3, 4]);
        $keys = [];
        foreach ($it as $key => $value) {
            $keys[] = $key;
        }

        // 'a' (string), 0 (numeric), 1 (numeric), 2 (numeric)
        self::assertSame(['a', 0, 1, 2], $keys);
    }

    /**
     * @return void
     */
    #[Test]
    public function rewindResetsAllIterators(): void
    {
        $it = new InterleaveIteratorIterator([1, 2], [3, 4]);
        $it->next();
        $it->rewind();

        $result = iterator_to_array($it, false);
        self::assertSame([1, 3, 2, 4], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function throwsIfNoIteratorsProvided(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new InterleaveIteratorIterator();
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithTwoArraysWillInterleaveCorrectly(): void
    {
        $it = new InterleaveIteratorIterator([1, 3, 5], [2, 4, 6]);
        $result = iterator_to_array($it, false);
        self::assertSame([1, 2, 3, 4, 5, 6], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithDifferentLengthWillContinueUntilAllExhausted(): void
    {
        $it = new InterleaveIteratorIterator([1, 3], [2, 4, 6]);
        $result = iterator_to_array($it, false);
        self::assertSame([1, 2, 3, 4, 6], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithSingleArrayWillReturnAllElements(): void
    {
        $it = new InterleaveIteratorIterator([10, 20, 30]);
        $result = iterator_to_array($it, false);
        self::assertSame([10, 20, 30], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithEmptyArraysWillReturnEmpty(): void
    {
        $it = new InterleaveIteratorIterator([], []);
        $result = iterator_to_array($it, false);
        self::assertSame([], $result);
    }
}
