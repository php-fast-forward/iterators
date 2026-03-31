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
use FastForward\Iterator\ClosureFactoryIteratorAggregate;

#[CoversClass(ClosureFactoryIteratorAggregate::class)]
#[CoversClass(IterableIterator::class)]
final class ClosureFactoryIteratorAggregateTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function getIteratorWithGeneratorWillIterateAllValues(): void
    {
        $agg = new ClosureFactoryIteratorAggregate(function () {
            yield 1;
            yield 2;
            yield 3;
        });
        $result = iterator_to_array($agg);
        self::assertSame([1, 2, 3], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function getIteratorWithArrayIteratorWillIterateAllValues(): void
    {
        $agg = new ClosureFactoryIteratorAggregate(fn(): ArrayIterator => new ArrayIterator([10, 20, 30]));
        $result = iterator_to_array($agg);
        self::assertSame([10, 20, 30], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function getIteratorWithGeneratorReturnStatementWillIgnoreReturn(): void
    {
        $agg = new ClosureFactoryIteratorAggregate(fn(): Generator => (function () {
            yield 'A';
            yield 'B';

            return 'ignored';
        })());
        $result = iterator_to_array($agg);
        self::assertSame(['A', 'B'], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function getIteratorWithEmptyGeneratorWillReturnEmptyArray(): void
    {
        $agg = new ClosureFactoryIteratorAggregate(fn(): Generator => (function () {
            if (false) {
                yield;
            }
        })());
        $result = iterator_to_array($agg);
        self::assertSame([], $result);
    }
}
