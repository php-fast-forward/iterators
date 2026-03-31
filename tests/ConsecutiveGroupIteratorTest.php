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
use FastForward\Iterator\ConsecutiveGroupIterator;

#[CoversClass(ConsecutiveGroupIterator::class)]
#[CoversClass(IterableIterator::class)]
final class ConsecutiveGroupIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function rewindWithConsecutiveEqualElementsWillGroupCorrectly(): void
    {
        $data = [1, 1, 2, 2, 2, 3, 4, 4, 5];
        $iterator = new ConsecutiveGroupIterator($data, fn($prev, $curr): bool => $prev === $curr);
        $result = iterator_to_array($iterator);
        self::assertSame([[1, 1], [2, 2, 2], [3], [4, 4], [5]], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function rewindWithAllDifferentElementsWillGroupEachIndividually(): void
    {
        $data = [1, 2, 3];
        $iterator = new ConsecutiveGroupIterator($data, fn($prev, $curr): false => false);
        $result = iterator_to_array($iterator);
        self::assertSame([[1], [2], [3]], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function rewindWithAllEqualElementsWillGroupAllTogether(): void
    {
        $data = [7, 7, 7];
        $iterator = new ConsecutiveGroupIterator($data, fn($prev, $curr): true => true);
        $result = iterator_to_array($iterator);
        self::assertSame([[7, 7, 7]], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function validWithEmptyInputWillReturnFalse(): void
    {
        $iterator = new ConsecutiveGroupIterator([], fn(): true => true);
        $iterator->rewind();
        self::assertFalse($iterator->valid());
    }

    /**
     * @return void
     */
    #[Test]
    public function currentWithNoValidChunkWillReturnEmptyArray(): void
    {
        $iterator = new ConsecutiveGroupIterator([], fn(): true => true);
        $iterator->rewind();
        self::assertSame([], $iterator->current());
    }
}
