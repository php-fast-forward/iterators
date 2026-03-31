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
use FastForward\Iterator\RepeatableIteratorIterator;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(RepeatableIteratorIterator::class)]
#[UsesClass(IterableIterator::class)]
final class RepeatableIteratorIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function foreachWithArrayAndLimitWillRepeatCorrectly(): void
    {
        $it = new RepeatableIteratorIterator([1, 2, 3], 5);
        $result = iterator_to_array($it, false);
        self::assertSame([1, 2, 3, 1, 2], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithOffsetWillStartAtCorrectPosition(): void
    {
        $it = new RepeatableIteratorIterator([10, 20, 30], 4, 1);
        $result = iterator_to_array($it, false);
        self::assertSame([20, 30, 10, 20], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function countWillReturnLimit(): void
    {
        $it = new RepeatableIteratorIterator([1, 2, 3], 7);
        self::assertSame(7, count($it));
    }
}
