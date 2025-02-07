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

use FastForward\Iterator\ClosureFactoryIteratorAggregate;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$len = 5;

/**
 * Generator function to produce values dynamically.
 *
 * @param int $len the number of values to generate
 *
 * @return Generator<int, string> a generator yielding formatted strings
 */
$generatorFactory = static function (int $len = 10) {
    for ($i = 0; $i < $len; ++$i) {
        yield 'Value: ' . ($i + $len);
    }
};

/**
 * Array-based factory to showcase alternative iteration strategy.
 *
 * @param int $len the number of values to include
 *
 * @return ArrayIterator<int, string> an ArrayIterator wrapping a static array
 */
$arrayFactory = static fn (int $len = 10) => new ArrayIterator(array_map(static fn ($i) => 'Value: ' . ($i + $len), range(0, $len - 1)));

// Using ClosureFactoryIteratorAggregate with a Generator function
$generatorIterator = new ClosureFactoryIteratorAggregate(static fn () => $generatorFactory($len));
// or
// $generatorIterator = new ClosureFactoryIteratorAggregate($generatorFactory);

// Using ClosureFactoryIteratorAggregate with an ArrayIterator
$arrayIterator = new ClosureFactoryIteratorAggregate(static fn () => $arrayFactory($len));

debugIterable(
    $generatorIterator,
    'ClosureFactoryIteratorAggregate :: Generator Strategy :: First Iteration',
);
debugIterable(
    $generatorIterator,
    'ClosureFactoryIteratorAggregate :: Generator Strategy :: Second Iteration',
);

debugIterable(
    $arrayIterator,
    'ClosureFactoryIteratorAggregate :: ArrayIterator Strategy :: First Iteration',
);
debugIterable(
    $arrayIterator,
    'ClosureFactoryIteratorAggregate :: ArrayIterator Strategy :: Second Iteration',
);
