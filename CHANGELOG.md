# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.3.1] - 2026-10-25

### Changed

- Synchronize the bundled local skill automatically and trust Fast Forward Composer
  skill donors through `fast-forward/*`.
  Resolve Changelog contributor skills from stable `0.4.x` releases without a
  redundant skill allowlist.
  Load the project autoloader for PHPDoc checks when DevTools is installed as a
  dependency.

  ([#10](https://github.com/php-fast-forward/iterators/pull/10))

## [1.3.0] - 2026-10-21

### Added

- Bundle the fast-forward-iterators consumer skill with executable examples, optional installation guidance and Composer discovery metadata, distinguishing independent generator-factory traversals from rewindable array inputs for lookahead. ([#8](https://github.com/php-fast-forward/iterators/pull/8))

### Changed

- Automate changelog checks, version pull requests and approved releases with Fast Forward Changelog, preserving existing GitHub release notes when creating the central history and making the project skill available to contributors. ([#7](https://github.com/php-fast-forward/iterators/pull/7))
- GitHub Actions(deps): bump php-fast-forward/dev-tools/.github/workflows/wiki-direct.yml from c637e7f9d8ae6059b8655996e56f6d17f874792c to 65ba0c50cf261ff4ab56ac4fbe6e373e52e2c9dc

  Update dependencies: `php-fast-forward/dev-tools/.github/workflows/wiki-direct.yml`.

  ([#6](https://github.com/php-fast-forward/iterators/pull/6), @dependabot[bot])
- Restore the Changelog skill from its GitHub source during Composer installation instead of committing a generated copy and separate installation receipt. ([#7](https://github.com/php-fast-forward/iterators/pull/7))

## [1.2.0] - 2026-03-31

**Full Changelog**: https://github.com/php-fast-forward/iterators/compare/v1.1.0...v1.2.0

## [1.1.0] - 2025-04-25

- Add new iterators
- Add support to iterable when constructing all iterators

## [1.0.0] - 2025-04-20

Release notes are unavailable for this version.

[1.3.1]: https://github.com/php-fast-forward/iterators/compare/v1.3.0...v1.3.1
[1.3.0]: https://github.com/php-fast-forward/iterators/compare/v1.2.0...v1.3.0
[1.2.0]: https://github.com/php-fast-forward/iterators/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/php-fast-forward/iterators/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/php-fast-forward/iterators/releases/tag/v1.0.0
