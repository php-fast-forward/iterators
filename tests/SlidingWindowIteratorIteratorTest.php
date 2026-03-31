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
use FastForward\Iterator\SlidingWindowIteratorIterator;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(SlidingWindowIteratorIterator::class)]
#[UsesClass(IterableIterator::class)]
final class SlidingWindowIteratorIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function keyWillReturnSequentialIndexForEachWindow(): void
    {
        $it = new SlidingWindowIteratorIterator([1, 2, 3, 4], 2);
        $keys = [];
        foreach ($it as $key => $window) {
            $keys[] = $key;
        }

        self::assertSame([0, 1, 2], $keys);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithArrayAndWindowSizeWillReturnSlidingWindows(): void
    {
        $it = new SlidingWindowIteratorIterator([1, 2, 3, 4, 5], 3);
        $result = iterator_to_array($it, false);
        self::assertSame([[1, 2, 3], [2, 3, 4], [3, 4, 5]], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithWindowSizeOneWillReturnSingleElements(): void
    {
        $it = new SlidingWindowIteratorIterator([10, 20, 30], 1);
        $result = iterator_to_array($it, false);
        self::assertSame([[10], [20], [30]], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithWindowSizeLargerThanArrayWillReturnEmpty(): void
    {
        $it = new SlidingWindowIteratorIterator([1, 2], 3);
        $result = iterator_to_array($it, false);
        self::assertSame([], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function constructWithInvalidWindowSizeWillThrow(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new SlidingWindowIteratorIterator([1, 2, 3], 0);
    }
}
