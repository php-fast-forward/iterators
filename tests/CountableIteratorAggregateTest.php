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
use FastForward\Iterator\CountableIteratorAggregate;
use FastForward\Iterator\CountableIteratorIteratorTrait;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(CountableIteratorAggregate::class)]
#[UsesTrait(CountableIteratorIteratorTrait::class)]
final class CountableIteratorAggregateTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function itIsCountable(): void
    {
        $aggregate = new class ([1, 2, 3]) extends CountableIteratorAggregate {
            /**
             * @param array $data
             */
            public function __construct(
                private readonly array $data
            ) {}

            /**
             * @return Traversable
             */
            public function getIterator(): Traversable
            {
                return new ArrayIterator($this->data);
            }
        };
        self::assertSame(3, count($aggregate));
        self::assertSame(0, count(new class ([]) extends CountableIteratorAggregate {
            /**
             * @return Traversable
             */
            public function getIterator(): Traversable
            {
                return new ArrayIterator([]);
            }
        }));
    }
}
