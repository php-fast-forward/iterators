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
use FastForward\Iterator\IterableIterator;

#[CoversClass(IterableIterator::class)]
final class IterableIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function constructWithArrayWillWrapAsArrayIterator(): void
    {
        $it = new IterableIterator([1, 2, 3]);
        self::assertInstanceOf(ArrayIterator::class, $it->getInnerIterator());
        self::assertSame([1, 2, 3], iterator_to_array($it));
    }

    /**
     * @return void
     */
    #[Test]
    public function constructWithTraversableWillWrapDirectly(): void
    {
        $traversable = new ArrayIterator([4, 5]);
        $it = new IterableIterator($traversable);
        self::assertSame([4, 5], iterator_to_array($it));
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithIterableIteratorWillIterateAllElements(): void
    {
        $it = new IterableIterator([10, 20]);
        $result = [];
        foreach ($it as $v) {
            $result[] = $v;
        }

        self::assertSame([10, 20], $result);
    }
}
