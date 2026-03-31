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

use FastForward\Iterator\FileExtensionFilterIterator;

use function FastForward\Iterator\debugIterable;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$directoryPath = __DIR__; // Change this to the directory you want to scan

/**
 * Creates a FileExtensionFilterIterator for a given directory.
 *
 * This example filters files with `.php` extension.
 *
 * @param string $directory the directory to scan
 * @param string ...$extensions The file extensions to allow.
 *
 * @return FileExtensionFilterIterator the filtered iterator
 */
$iterator = new FileExtensionFilterIterator(new FilesystemIterator($directoryPath), 'php');

debugIterable($iterator, 'FileExtensionFilterIterator :: Filtering .php and .txt files');

/**
 * Creates a recursive FileExtensionFilterIterator to scan subdirectories.
 *
 * This example filters `.md` and `.json` files recursively.
 *
 * @param string $directory the directory to scan recursively
 * @param string ...$extensions The file extensions to allow.
 *
 * @return FileExtensionFilterIterator the filtered recursive iterator
 */
$recursiveIterator = new FileExtensionFilterIterator(
    new RecursiveDirectoryIterator(dirname($directoryPath), FilesystemIterator::SKIP_DOTS),
    '.md',
    'json'
);

debugIterable($recursiveIterator, 'FileExtensionFilterIterator :: Recursive filtering .log and .json files');
