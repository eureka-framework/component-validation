# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).


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
