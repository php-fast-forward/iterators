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
use FastForward\Iterator\GroupByIteratorIterator;
use FastForward\Iterator\IterableIterator;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(GroupByIteratorIterator::class)]
#[UsesClass(IterableIterator::class)]
final class GroupByIteratorIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function groupByWithArrayWillGroupByCallback(): void
    {
        $data = [
            [
                'name' => 'Alice',
                'age' => 25,
            ],
            [
                'name' => 'Bob',
                'age' => 30,
            ],
            [
                'name' => 'Charlie',
                'age' => 25,
            ],
        ];
        $it = new GroupByIteratorIterator($data, fn($item) => $item['age']);
        $result = iterator_to_array($it);
        self::assertArrayHasKey(25, $result);
        self::assertArrayHasKey(30, $result);
        self::assertCount(2, $result[25]);
        self::assertCount(1, $result[30]);
        self::assertSame('Alice', $result[25][0]['name']);
        self::assertSame('Charlie', $result[25][1]['name']);
        self::assertSame('Bob', $result[30][0]['name']);
    }

    /**
     * @return void
     */
    #[Test]
    public function groupByWithEmptyArrayWillReturnEmpty(): void
    {
        $it = new GroupByIteratorIterator([], fn($item) => $item);
        $result = iterator_to_array($it);
        self::assertSame([], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function groupByWithStringKeys(): void
    {
        $data = [
            [
                'type' => 'fruit',
                'name' => 'Apple',
            ],
            [
                'type' => 'vegetable',
                'name' => 'Carrot',
            ],
            [
                'type' => 'fruit',
                'name' => 'Banana',
            ],
        ];
        $it = new GroupByIteratorIterator($data, fn($item) => $item['type']);
        $result = iterator_to_array($it);
        self::assertArrayHasKey('fruit', $result);
        self::assertArrayHasKey('vegetable', $result);
        self::assertCount(2, $result['fruit']);
        self::assertCount(1, $result['vegetable']);
    }
}
