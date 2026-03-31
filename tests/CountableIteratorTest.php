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
use FastForward\Iterator\CountableIterator;
use FastForward\Iterator\CountableIteratorIteratorTrait;
use PHPUnit\Framework\Attributes\UsesTrait;

#[CoversClass(CountableIterator::class)]
#[UsesTrait(CountableIteratorIteratorTrait::class)]
final class CountableIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function countReturnsNumberOfElements(): void
    {
        $iterator = new class ([1, 2, 3]) extends CountableIterator {
            private int $position = 0;

            /**
             * @param array $data
             */
            public function __construct(
                private array $data
            ) {}

            /**
             * @return mixed
             */
            public function current(): mixed
            {
                return $this->data[$this->position];
            }

            /**
             * @return mixed
             */
            public function key(): mixed
            {
                return $this->position;
            }

            /**
             * @return void
             */
            public function next(): void
            {
                ++$this->position;
            }

            /**
             * @return void
             */
            public function rewind(): void
            {
                $this->position = 0;
            }

            /**
             * @return bool
             */
            public function valid(): bool
            {
                return $this->position < count($this->data);
            }
        };
        self::assertSame(3, $iterator->count());
    }

    /**
     * @return void
     */
    #[Test]
    public function countReturnsZeroForEmptyIterator(): void
    {
        $iterator = new class ([]) extends CountableIterator {
            private int $position = 0;

            /**
             * @param array $data
             */
            public function __construct(
                private array $data
            ) {}

            /**
             * @return mixed
             */
            public function current(): mixed
            {
                return $this->data[$this->position] ?? null;
            }

            /**
             * @return mixed
             */
            public function key(): mixed
            {
                return $this->position;
            }

            /**
             * @return void
             */
            public function next(): void
            {
                ++$this->position;
            }

            /**
             * @return void
             */
            public function rewind(): void
            {
                $this->position = 0;
            }

            /**
             * @return bool
             */
            public function valid(): bool
            {
                return $this->position < count($this->data);
            }
        };
        self::assertSame(0, $iterator->count());
    }

    /**
     * @return void
     */
    #[Test]
    public function countWorksWithNonNumericKeys(): void
    {
        $iterator = new class ([
            'a' => 1,
            'b' => 2,
        ]) extends CountableIterator {
            private array $keys;

            private int $position = 0;

            /**
             * @param array $data
             */
            public function __construct(
                private array $data
            ) {
                $this->keys = array_keys($this->data);
            }

            /**
             * @return mixed
             */
            public function current(): mixed
            {
                return $this->data[$this->keys[$this->position]];
            }

            /**
             * @return mixed
             */
            public function key(): mixed
            {
                return $this->keys[$this->position];
            }

            /**
             * @return void
             */
            public function next(): void
            {
                ++$this->position;
            }

            /**
             * @return void
             */
            public function rewind(): void
            {
                $this->position = 0;
            }

            /**
             * @return bool
             */
            public function valid(): bool
            {
                return $this->position < count($this->data);
            }
        };
        self::assertSame(2, $iterator->count());
    }
}
