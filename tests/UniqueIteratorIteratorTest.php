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
use FastForward\Iterator\UniqueIteratorIterator;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(UniqueIteratorIterator::class)]
#[UsesClass(IterableIterator::class)]
final class UniqueIteratorIteratorTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function keyWillReturnSequentialPosition(): void
    {
        $it = new UniqueIteratorIterator([10, 20, 10, 30]);
        $keys = [];
        foreach ($it as $key => $value) {
            $keys[] = $key;
        }

        self::assertSame([0, 1, 2], $keys);
    }

    /**
     * @return void
     */
    #[Test]
    public function skipDuplicatesWithCaseInsensitiveWillLowercase(): void
    {
        $it = new UniqueIteratorIterator(['A', 'a', 'B', 'b'], true, false);
        $result = iterator_to_array($it, false);
        self::assertSame(['A', 'B'], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithDuplicatesWillReturnUniqueValues(): void
    {
        $it = new UniqueIteratorIterator([1, 2, 2, 3, 4, 4, 5]);
        $result = iterator_to_array($it, false);
        self::assertSame([1, 2, 3, 4, 5], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithEmptyArrayWillReturnEmpty(): void
    {
        $it = new UniqueIteratorIterator([]);
        $result = iterator_to_array($it, false);
        self::assertSame([], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithStrictFalseWillAllowSimilarButNotIdentical(): void
    {
        $it = new UniqueIteratorIterator(['a', 'A', 'b', 'B', 'a'], false);
        $result = iterator_to_array($it, false);
        self::assertSame(['a', 'A', 'b', 'B'], $result);
    }

    /**
     * @return void
     */
    #[Test]
    public function foreachWithStrictTrueWillTreatCaseDifferently(): void
    {
        $it = new UniqueIteratorIterator(['a', 'A', 'a', 'A'], true);
        $result = iterator_to_array($it, false);
        self::assertSame(['a', 'A'], $result);
    }
}
