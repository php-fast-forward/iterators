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

use FastForward\Iterator\ClosureIteratorIterator;
use FastForward\Iterator\IterableIterator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use FastForward\Iterator\TrimIteratorIterator;

#[CoversClass(TrimIteratorIterator::class)]
#[CoversClass(ClosureIteratorIterator::class)]
#[CoversClass(IterableIterator::class)]
final class TrimIteratorIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function foreachWithDefaultTrimWillTrimWhitespace(): void
    {
        $data = ['  hello  ', "\nworld\n", "\tPHP\t"];
        $it = new TrimIteratorIterator($data);
        $result = iterator_to_array($it);
        self::assertSame(['hello', 'world', 'PHP'], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithCustomCharactersWillTrimCorrectly(): void
    {
        $data = ['--Hello--', '**World**', '!!PHP!!'];
        $it = new TrimIteratorIterator($data, '-*!');
        $result = iterator_to_array($it);
        self::assertSame(['Hello', 'World', 'PHP'], array_values($result));
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithEmptyArrayWillReturnEmpty(): void
    {
        $it = new TrimIteratorIterator([]);
        $result = iterator_to_array($it);
        self::assertSame([], $result);
    }
}
