<?php

declare(strict_types=1);

/**
 * This file is part of php-fast-forward/iterators.
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 *
 * @link      https://github.com/php-fast-forward/iterators
 * @copyright Copyright (c) 2025 Felipe Sayão Lobato Abreu <github@mentordosnerds.com>
 * @license   https://opensource.org/licenses/MIT MIT License
 */

namespace FastForward\Iterator;

/**
 * Class TrimIteratorIterator.
 *
 * An iterator that trims each value within a `Traversable`.
 *
 * This class extends `ClosureIteratorIterator` and applies `trim()`
 * to each element, removing leading and trailing characters based on
 * the specified character mask.
 *
 * ## Usage Example:
 *
 * @example Basic Usage
 * ```php
 * use FastForward\Iterator\TrimIteratorIterator;
 * use ArrayIterator;
 *
 * $data = new ArrayIterator(["  hello  ", "\nworld\n", "\tPHP\t"]);
 * $trimIterator = new TrimIteratorIterator($data);
 *
 * foreach ($trimIterator as $value) {
 *     echo $value . ' | '; // Outputs: "hello | world | PHP | "
 * }
 * ```
 * @example Custom Trim Characters
 * ```php
 * use FastForward\Iterator\TrimIteratorIterator;
 * use ArrayIterator;
 *
 * $data = new ArrayIterator(["--Hello--", "**World**", "!!PHP!!"]);
 * $trimIterator = new TrimIteratorIterator($data, "-*!");
 *
 * foreach ($trimIterator as $value) {
 *     echo $value . ' | '; // Outputs: "Hello | World | PHP | "
 * }
 * ```
 *
 * **Note:** If `$characters` is `null`, the default trim characters
 * (`" \n\r\t\v\x00"`) will be used.
 *
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class TrimIteratorIterator extends ClosureIteratorIterator
{
    /**
     * @var string the default characters to trim
     */
    private const DEFAULT_CHARACTERS = " \n\r\t\v\x00";

    /**
     * Initializes the TrimIteratorIterator.
     *
     * @param iterable    $iterator   the iterator containing values to be trimmed
     * @param null|string $characters A string defining the characters to be trimmed.
     *                                Defaults to standard whitespace characters.
     */
    public function __construct(iterable $iterator, ?string $characters = self::DEFAULT_CHARACTERS)
    {
        parent::__construct(
            new IterableIterator($iterator),
            static fn ($current) => mb_trim($current, $characters ?? self::DEFAULT_CHARACTERS)
        );
    }
}
