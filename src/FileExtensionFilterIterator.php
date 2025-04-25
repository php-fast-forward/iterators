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
 * Class FileExtensionFilterIterator.
 *
 * A filter iterator that only accepts files matching specified extensions.
 *
 * This iterator is designed to traverse a directory and filter files
 * by their extension. It supports both `FilesystemIterator` and `RecursiveIterator`.
 *
 * ## Usage Example:
 *
 * @example
 * ```php
 * use FastForward\Iterator\FileExtensionFilterIterator;
 * use FilesystemIterator;
 *
 * $directory = new FilesystemIterator('/path/to/directory');
 *
 * $iterator = new FileExtensionFilterIterator($directory, 'txt', 'php');
 *
 * foreach ($iterator as $file) {
 *     echo $file->getFilename(); // Outputs only .txt and .php files
 * }
 * ```
 *
 * **Note:** If a `RecursiveIterator` is provided, the iterator will traverse subdirectories.
 *
 * @package FastForward\Iterator
 *
 * @since 1.0.0
 */
class FileExtensionFilterIterator extends \FilterIterator
{
    /**
     * The file extensions to accept.
     *
     * @var string[]
     */
    private array $extensions;

    /**
     * Initializes the FileExtensionFilterIterator.
     *
     * @param \FilesystemIterator|\RecursiveDirectoryIterator $iterator      the directory iterator to wrap
     * @param string                                          ...$extensions The allowed file extensions.
     */
    public function __construct(\FilesystemIterator $iterator, string ...$extensions)
    {
        $this->extensions = array_map(
            static fn (string $fileType): string => mb_ltrim($fileType, '.'),
            $extensions
        );

        $innerIterator = $iterator instanceof \RecursiveIterator
            ? new \RecursiveIteratorIterator($iterator)
            : new \IteratorIterator($iterator);

        parent::__construct($innerIterator);
    }

    /**
     * Determines whether the current file should be accepted.
     *
     * - Directories are accepted only if the underlying iterator is recursive.
     * - Files are accepted only if their extension matches the allowed list.
     *
     * @return bool true if the file is accepted, false otherwise
     */
    public function accept(): bool
    {
        /** @var \SplFileInfo $current */
        $current = $this->current();

        if ($current->isDir()) {
            return $this->getInnerIterator() instanceof \RecursiveIterator;
        }

        $extension = pathinfo($current->getFilename(), PATHINFO_EXTENSION);

        return \in_array($extension, $this->extensions, true);
    }
}
