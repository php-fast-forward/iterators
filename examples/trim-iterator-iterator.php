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

use FastForward\Iterator\TrimIteratorIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Sample dataset with untrimmed strings.
 *
 * @var ArrayIterator<int, string>
 */
$data = new ArrayIterator(['  hello  ', "\nworld\n", "\tPHP\t", '  trim test  ']);

/**
 * Creates a TrimIteratorIterator with default whitespace trimming.
 */
$trimIterator = new TrimIteratorIterator($data);

/**
 * Creates a TrimIteratorIterator with custom characters trimming.
 *
 * This example removes hyphens (`-`), asterisks (`*`), and exclamation marks (`!`).
 */
$dataCustom         = new ArrayIterator(['--Hello--', '**World**', '!!PHP!!']);
$trimIteratorCustom = new TrimIteratorIterator($dataCustom, '-*!');

// Debugging the TrimIteratorIterator output.
debugIterable($trimIterator, 'TrimIteratorIterator :: Default Whitespace Trimming');
debugIterable($trimIteratorCustom, 'TrimIteratorIterator :: Custom Character Trimming');
