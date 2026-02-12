# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [6.2.0] - 2026-02-12
[6.2.0]: https://github.com/eureka-framework/component-validation/compare/6.1.0...6.2.0
### Changed
- GenericEntity data now accept mixed rather than limited types


## [6.1.0] - 2026-01-05
[6.1.0]: https://github.com/eureka-framework/component-validation/compare/6.0.0...6.1.0
### Added
- Support for PHP 8.5
### Changed
- Update CI GitHub Action
- Update dev dependencies


## [6.0.0] - 2025-08-015
[6.0.0]: https://github.com/eureka-framework/component-validation/compare/5.3.0...6.0.0
### Added
- Support for PHP 8.4
### Removed
- Drop support for PHP 7.4, 8.0, 8.1, and 8.2
### Changed
- String validator now throws an exception if values has not the required length, rather than returning default value.
- Boolean validator now return `null` if the value is not a boolean, rather than return `false`.
- Type as enforced on validator to return appropriate type (or null if applicable)
- CI improvements

---

## [5.3.0] - 2024-02-06
[5.3.0]: https://github.com/eureka-framework/component-validation/compare/5.2.0...5.3.0
### Changed
- Now compatible with PHP 8.3
- Update github workflow

## [5.2.0] - 2023-06-14
[5.2.0]: https://github.com/eureka-framework/component-validation/compare/5.1.0...5.2.0
### Changed
- Now compatible with PHP 8.2
- Update Makefile
- Update composer.json
- Update GitHub workflow
### Added
- Add phpstan config for PHP 8.2 compatibility

## [5.1.0] - 2022-03-08
[5.1.0]: https://github.com/eureka-framework/component-validation/compare/5.0.1...5.1.0
### Changed
 * CI improvements (php compatibility check, makefile, github workflow)
 * Now compatible with PHP 7.4, 8.0 & 8.1
 * Fix phpdoc + some return type according to phpstan analysis
### Added
 * phpstan for static analysis
### Removed
 * phpcompatibility (no more maintained)

## [5.0.1] - 2020-10-29
[5.0.1]: https://github.com/eureka-framework/component-validation/compare/5.0.0...5.0.1
### Changed
 * Require phpcodesniffer v0.7 for composer 2.0
 
## [5.0.0] - 2020-10-29
[5.0.0]: https://github.com/eureka-framework/component-validation/compare/2.0.0...5.0.0
### Changed
 * New require PHP 7.4+
 * Minor fixed & improvements
### Added
 * Tests for full coverage
 * Readme with some examples
### Removed
 * Some unused code


## [2.0.0-2.1.1] - 2019-04-03
[2.0.0-2.1.1]: https://github.com/eureka-framework/component-validation/compare/1.0.0...2.1.1
### Changed
  * Rename validation entity
  * Update validation factory
  * Update validation factory interface
### Added
  * Add entity interface
  * Add entity factory

## [1.0.0] - Release v1.0.0
### Added
 * Add mains Validators classes
 * Add ValidatorInterface
 * Add ValidationException
 * Add tests for validators
 * Add factory & generic entity for forms
### Changed
* Update composer.json
