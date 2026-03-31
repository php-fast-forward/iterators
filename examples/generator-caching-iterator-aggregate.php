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

use FastForward\Iterator\GeneratorCachingIteratorAggregate;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Number of elements to generate.
 *
 * @var int
 */
$len = 5;

/**
 * Factory function for generating a sequence of values.
 *
 * This function yields a series of formatted string values dynamically.
 *
 * @param int $len the number of values to generate
 *
 * @return Generator<int, string> a generator yielding formatted strings
 */
$generatorFactory = static function (int $len = 10): Generator {
    for ($i = 0; $i < $len; ++$i) {
        yield 'Value: ' . ($i + $len);
    }
};

/**
 * Creates a GeneratorCachingIteratorAggregate using a callable factory.
 *
 * This approach allows lazy execution of the generator when iterated.
 *
 * @var GeneratorCachingIteratorAggregate<string>
 */
$generatorCallableCache = new GeneratorCachingIteratorAggregate(static fn(): Generator => $generatorFactory($len));

/**
 * Creates a GeneratorCachingIteratorAggregate using a directly instantiated generator.
 *
 * This approach evaluates the generator immediately and caches the result.
 *
 * @var GeneratorCachingIteratorAggregate<string>
 */
$generatorCache = new GeneratorCachingIteratorAggregate($generatorFactory($len));

// Debugging first and second iterations to demonstrate caching.
debugIterable(
    $generatorCallableCache,
    'GeneratorCachingIteratorAggregate :: Generator Closure Strategy :: First Iteration'
);
debugIterable(
    $generatorCallableCache,
    'GeneratorCachingIteratorAggregate :: Generator Closure Strategy :: Second Iteration'
);

debugIterable($generatorCache, 'GeneratorCachingIteratorAggregate :: Generator Strategy :: First Iteration');
debugIterable($generatorCache, 'GeneratorCachingIteratorAggregate :: Generator Strategy :: Second Iteration');
