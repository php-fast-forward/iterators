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

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function FastForward\Iterator\debugIterable;

#[CoversFunction('FastForward\\Iterator\\debugIterable')]
final class FunctionsTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function debugIterableWithStringValueWillQuoteString(): void
    {
        $iterator = new ArrayIterator([
            'foo' => 'bar',
        ]);
        ob_start();
        debugIterable($iterator, 'StringValue');
        $output = ob_get_clean();
        self::assertStringContainsString('  "foo" => "bar",', $output);
    }

    /**
     * @return void
     */
    #[Test]
    public function debugIterableWithStringableValueWillQuoteString(): void
    {
        $stringable = new class {
            /**
             * @return string
             */
            public function __toString(): string
            {
                return 'baz';
            }
        };
        $iterator = new ArrayIterator([
            'foo' => $stringable,
        ]);
        ob_start();
        debugIterable($iterator, 'StringableValue');
        $output = ob_get_clean();
        self::assertStringContainsString('  "foo" => "baz",', $output);
    }

    /**
     * @return void
     */
    #[Test]
    public function debugIterableWithArrayIteratorWillPrintExpectedOutput(): void
    {
        $iterator = new ArrayIterator([
            'a' => 1,
            'b' => 2,
        ]);
        ob_start();
        debugIterable($iterator, 'Test Section');
        $output = ob_get_clean();
        $expected = ['=== Test Section ===', 'Length: 2', 'Output: [', '  "a" => 1,', '  "b" => 2,', ']'];
        foreach ($expected as $line) {
            self::assertStringContainsString($line, $output);
        }
    }

    /**
     * @return void
     */
    #[Test]
    public function debugIterableWithDefaultSectionWillUseClassName(): void
    {
        $iterator = new ArrayIterator([1]);
        ob_start();
        debugIterable($iterator);
        $output = ob_get_clean();
        self::assertStringContainsString('=== ArrayIterator ===', $output);
    }

    /**
     * @return void
     */
    #[Test]
    public function debugIterableWithNonScalarValueWillJsonEncode(): void
    {
        $iterator = new ArrayIterator([
            'x' => [1, 2],
        ]);
        ob_start();
        debugIterable($iterator, 'NonScalar');
        $output = ob_get_clean();
        $expectedBlock = <<<TXT
              "x" => [
                1,
                2
            ],
            TXT;
        self::assertStringContainsString($expectedBlock, $output);
    }
}
