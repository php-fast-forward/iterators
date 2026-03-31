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

use FastForward\Iterator\GeneratorRewindableIterator;
use FastForward\Iterator\RepeatableIteratorIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * The number of elements to generate.
 *
 * @var int
 */
$len = 5;

/**
 * Factory function to generate a sequence of numbers.
 *
 * @param int $len the number of values to generate
 *
 * @return Generator<int, int> a generator yielding a sequence of numbers
 */
$generatorFactory = static function (int $len = 10): Generator {
    for ($i = 0; $i < $len; ++$i) {
        yield $i + $len;
    }
};

/**
 * GeneratorRewindableIterator created using a callable factory.
 *
 * This approach allows for lazy execution of the generator.
 *
 * @var GeneratorRewindableIterator<int>
 */
$generatorRewindable = new GeneratorRewindableIterator(static fn(): Generator => $generatorFactory($len));

/**
 * GeneratorRewindableIterator created with a directly instantiated generator.
 *
 * This forces the generator to be evaluated immediately.
 *
 * @var GeneratorRewindableIterator<int>
 */
$generatorFactoryRewindable = new GeneratorRewindableIterator($generatorFactory($len));

/**
 * RepeatableIteratorIterator wrapping the GeneratorRewindableIterator.
 *
 * This allows repeated iteration over the same set of generated values.
 *
 * @var RepeatableIteratorIterator<int>
 */
$repeatable = new RepeatableIteratorIterator($generatorRewindable, $len * 3);

// Debugging different strategies
debugIterable($generatorRewindable, 'GeneratorRewindableIterator :: Generator Strategy');
debugIterable($generatorFactoryRewindable, 'GeneratorRewindableIterator :: Generator Factory Strategy');
debugIterable($repeatable, 'GeneratorRewindableIterator :: RepeatableIteratorIterator Strategy');
