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
use FastForward\Iterator\ClosureIteratorIterator;
use FastForward\Iterator\IterableIterator;

#[CoversClass(ClosureIteratorIterator::class)]
#[CoversClass(IterableIterator::class)]
class ClosureIteratorIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function constructWithArrayAndClosureWillTransformValues(): void
    {
        $input = [1, 2, 3];
        $closure = fn($value): int|float => $value * 2;
        $iterator = new ClosureIteratorIterator($input, $closure);
        $result = iterator_to_array($iterator, false);
        self::assertSame([2, 4, 6], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function constructWithIteratorAndClosureWillTransformValues(): void
    {
        $input = new ArrayIterator([10, 20, 30]);
        $closure = fn($value, $key): float|int|array => $value + $key;
        $iterator = new ClosureIteratorIterator($input, $closure);
        $result = iterator_to_array($iterator, false);
        self::assertSame([10, 21, 32], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function closureCanAccessKey(): void
    {
        $input = [
            'a' => 5,
            'b' => 10,
        ];
        $closure = fn($value, $key): string => $key . ':' . $value;
        $iterator = new ClosureIteratorIterator($input, $closure);
        $result = iterator_to_array($iterator, false);
        self::assertSame(['a:5', 'b:10'], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function emptyInputWillReturnEmpty(): void
    {
        $input = [];
        $closure = fn($value) => $value;
        $iterator = new ClosureIteratorIterator($input, $closure);
        $result = iterator_to_array($iterator, false);
        self::assertSame([], $result);
    }

    /**
     * @return void
     *
     * @throws InvalidArgumentException
     */
    #[Test]
    public function closureCanThrowException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $input = [1, 2, 3];
        $closure = function ($value) {
            if (2 === $value) {
                throw new InvalidArgumentException('Invalid value');
            }

            return $value;
        };
        $iterator = new ClosureIteratorIterator($input, $closure);
        foreach ($iterator as $v) {
            // Will throw on value 2
        }
    }
}
