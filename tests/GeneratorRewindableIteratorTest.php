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

use FastForward\Iterator\GeneratorCachingIteratorAggregate;
use FastForward\Iterator\ClosureFactoryIteratorAggregate;
use FastForward\Iterator\IterableIterator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use FastForward\Iterator\GeneratorRewindableIterator;

#[CoversClass(GeneratorRewindableIterator::class)]
#[CoversClass(GeneratorCachingIteratorAggregate::class)]
#[CoversClass(ClosureFactoryIteratorAggregate::class)]
#[CoversClass(IterableIterator::class)]
final class GeneratorRewindableIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function rewindWithGeneratorWillAllowMultipleIterations(): void
    {
        $gen = function () {
            yield 'A';
            yield 'B';
            yield 'C';
        };
        $it = new GeneratorRewindableIterator($gen());
        $result1 = iterator_to_array($it);
        $result2 = iterator_to_array($it);
        self::assertSame(['A', 'B', 'C'], array_values($result1));
        self::assertSame(['A', 'B', 'C'], array_values($result2));
    }

    /**
     * @return void
     */
    #[Test]
    public function rewindWithClosureReturningGeneratorWillAllowMultipleIterations(): void
    {
        $it = new GeneratorRewindableIterator(fn(): Generator => (function () {
            yield 1;
            yield 2;
            yield 3;
        })());
        $result1 = iterator_to_array($it);
        $result2 = iterator_to_array($it);
        self::assertSame([1, 2, 3], array_values($result1));
        self::assertSame([1, 2, 3], array_values($result2));
    }

    /**
     * @return void
     */
    #[Test]
    public function validWithEmptyGeneratorWillReturnFalse(): void
    {
        $it = new GeneratorRewindableIterator(fn(): Generator => (function () {
            if (false) {
                yield;
            }
        })());
        $it->rewind();
        self::assertFalse($it->valid());
    }

    /**
     * @return void
     */
    #[Test]
    public function keyAndCurrentWillReturnExpectedValues(): void
    {
        $it = new GeneratorRewindableIterator(fn(): Generator => (function () {
            yield 'x' => 10;
            yield 'y' => 20;
        })());
        $it->rewind();
        self::assertSame('x', $it->key());
        self::assertSame(10, $it->current());
        $it->next();
        self::assertSame('y', $it->key());
        self::assertSame(20, $it->current());
    }
}
