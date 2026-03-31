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
use FastForward\Iterator\LookaheadIterator;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(LookaheadIterator::class)]
#[UsesClass(IterableIterator::class)]
final class LookaheadIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function lookAheadAndLookBehindWorkAsExpected(): void
    {
        $it = new LookaheadIterator(['A', 'B', 'C', 'D']);
        $result = [];
        foreach ($it as $value) {
            $result[] = [
                'current' => $value,
                'next'    => $it->lookAhead(),
                'prev'    => $it->lookBehind(),
            ];
        }

        self::assertSame([
            [
                'current' => 'A',
                'next' => 'B',
                'prev' => null,
            ],
            [
                'current' => 'B',
                'next' => 'C',
                'prev' => 'A',
            ],
            [
                'current' => 'C',
                'next' => 'D',
                'prev' => 'B',
            ],
            [
                'current' => 'D',
                'next' => null,
                'prev' => 'C',
            ],
        ], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function lookAheadWithCountReturnsArray(): void
    {
        $it = new LookaheadIterator([1, 2, 3, 4]);
        $it->rewind();
        self::assertSame([2, 3], $it->lookAhead(2));
    }

    /**
     * @return void
     */
    #[Test]
    public function lookBehindWithCountReturnsArray(): void
    {
        $it = new LookaheadIterator([1, 2, 3, 4]);
        foreach ($it as $v) {
            if (4 === $v) {
                self::assertSame([2, 3], $it->lookBehind(2));
            }
        }
    }

    /**
     * @return void
     */
    #[Test]
    public function lookAheadWithInvalidCountThrows(): void
    {
        $it = new LookaheadIterator([1, 2, 3]);
        $this->expectException(InvalidArgumentException::class);
        $it->lookAhead(0);
    }

    /**
     * @return void
     */
    #[Test]
    public function lookBehindWithInvalidCountThrows(): void
    {
        $it = new LookaheadIterator([1, 2, 3]);
        $this->expectException(InvalidArgumentException::class);
        $it->lookBehind(0);
    }
}
