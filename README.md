# FastForward\Iterators

[![PHP Version](https://img.shields.io/badge/php-^8.3-777BB4?logo=php&logoColor=white)](https://www.php.net/releases/)
[![Composer Package](https://img.shields.io/badge/composer-fast--forward%2Fiterators-F28D1A.svg?logo=composer&logoColor=white)](https://packagist.org/packages/fast-forward/iterators)
[![Tests](https://img.shields.io/github/actions/workflow/status/php-fast-forward/iterators/tests.yml?logo=githubactions&logoColor=white&label=tests&color=22C55E)](https://github.com/php-fast-forward/iterators/actions/workflows/tests.yml)
[![Coverage](https://img.shields.io/badge/coverage-phpunit-4ADE80?logo=php&logoColor=white)](https://php-fast-forward.github.io/iterators/coverage/index.html)
[![Docs](https://img.shields.io/github/deployments/php-fast-forward/iterators/github-pages?logo=readthedocs&logoColor=white&label=docs&labelColor=1E293B&color=38BDF8&style=flat)](https://php-fast-forward.github.io/iterators/index.html)
[![License](https://img.shields.io/github/license/php-fast-forward/iterators?color=64748B)](LICENSE)
[![GitHub Sponsors](https://img.shields.io/github/sponsors/php-fast-forward?logo=githubsponsors&logoColor=white&color=EC4899)](https://github.com/sponsors/php-fast-forward)

A robust and optimized library for advanced PHP Iterators.

Enhance your PHP applications with high-performance iterators: lookahead, peeking, filtering, grouping, chunking, and more.

---

## ✨ Features

- 🔁 Advanced and composable iterator types
- 👀 Lookahead and peeking support
- 🧼 Filtering and mapping
- 🧩 Grouping, chunking, and flattening
- 🧪 Fully tested, mutation safe, and statically analyzed

## 📦 Installation

Install via Composer:

```bash
composer require fast-forward/iterators
```

**Requirements:** PHP 8.3 or higher

## 🚀 Quickstart

```php
use FastForward\Iterator\ChunkedIteratorAggregate;

$data = range(1, 10);
$chunked = new ChunkedIteratorAggregate($data, 3);
foreach ($chunked as $chunk) {
    print_r($chunk);
}
```

**Expected output:**

```plain
Array
(
    [0] => 1
    [1] => 2
    [2] => 3
)
Array
(
    [0] => 4
    [1] => 5
    [2] => 6
)
Array
(
    [0] => 7
    [1] => 8
    [2] => 9
)
Array
(
    [0] => 10
)
```

## 🛠 Usage Patterns

All iterators and utilities are available under the `FastForward\Iterator` namespace. Simply require Composer's autoloader:

```php
require_once 'vendor/autoload.php';
use FastForward\Iterator\ChunkedIteratorAggregate;
use FastForward\Iterator\SlidingWindowIteratorIterator;
// ...
```

You can chain, compose, and adapt iterators for a wide variety of data processing tasks.

## 📚 Documentation & Examples

- 📖 [Full Documentation](https://github.com/php-fast-forward/iterators/tree/main/docs)
- 🧑‍💻 [Examples Directory](https://github.com/php-fast-forward/iterators/tree/main/examples)
  - Each file demonstrates a specific iterator or pattern:
    - [chunked-iterator-aggregate.php](https://github.com/php-fast-forward/iterators/blob/main/examples/chunked-iterator-aggregate.php)
    - [sliding-window-iterator-iterator.php](https://github.com/php-fast-forward/iterators/blob/main/examples/sliding-window-iterator-iterator.php)
    - [unique-iterator-iterator.php](https://github.com/php-fast-forward/iterators/blob/main/examples/unique-iterator-iterator.php)
    - [lookahead-iterator.php](https://github.com/php-fast-forward/iterators/blob/main/examples/lookahead-iterator.php)
    - ...and more!

## 🤝 Contributing

Contributions, bug reports and suggestions are welcome! Please open an issue or pull request on [GitHub](https://github.com/php-fast-forward/iterators).

## 🧑‍💻 Author

**Felipe Sayão Lobato Abreu**  
<github@mentordosnerds.com>

## 📄 License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).
