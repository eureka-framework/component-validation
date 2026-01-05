# component-validation

[![Current version](https://img.shields.io/packagist/v/eureka/component-validation.svg?logo=composer)](https://packagist.org/packages/eureka/component-validation)
[![Supported PHP version](https://img.shields.io/static/v1?logo=php&label=PHP&message=>%3D8.3&color=777bb4)](https://packagist.org/packages/eureka/component-validation)
![CI](https://github.com/eureka-framework/component-validation/workflows/CI/badge.svg)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=eureka-framework_component-validation&metric=alert_status)](https://sonarcloud.io/dashboard?id=eureka-framework_component-validation)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=eureka-framework_component-validation&metric=coverage)](https://sonarcloud.io/dashboard?id=eureka-framework_component-validation)


Validation Component

## Usage

### Validator Factory
Validation component use php native `filter_var()` to validate contents.
Please refer to [Validate filters](https://www.php.net/manual/en/filter.filters.validate.php) and 
[filter_var()](https://www.php.net/manual/en/function.filter-var.php) for more information about options & flags.

```php
<?php

use Eureka\Component\Validation\ValidatorFactory;

$factory = new ValidatorFactory();

$string = 'message';

$validatedString = $factory->getValidator('string')->validate($string);
$validatedEmail  = $factory->getValidator('email')->validate('test@example.com');
//...
```


### Generic Entity

Validation component could be used to validate form. But to avoid set an invalid domain entity (a domain Entity should 
always be complete and valid), you can use generic entity factory.

This factory can create a pseudo entity with auto validation, and create or update a domain Entity only if the generic
entity is valid.
```php
<?php

use Eureka\Component\Validation\Entity\ValidatorEntityFactory;
use Eureka\Component\Validation\ValidatorFactory;
use Eureka\Component\Validation\Validator\IntegerValidator;

//~ Key as formatted in PascalCase in generic entity
$formData = [
    'userId'     => 1,
    'userName'   => 'Romain',
    'user_email' => 'test@example.com',
    'IsEnabled'  => true,
];

//~ Key as formatted in PascalCase in generic entity also for the config 
$validatorConfig = [
    'user_id'   => ['type' => 'integer', 'options' => IntegerValidator::INT_UNSIGNED],
    'UserEmail' => ['type' => 'email'],
];

$entityFactory = new ValidatorEntityFactory(new ValidatorFactory());
$formEntity = $entityFactory->createGeneric($validatorConfig, $formData);

if (!$formEntity->isValid()) {
    throw new \RuntimeException(implode("\n", $formEntity->getErrors()));
}

$user = new User();
$user->setId($formEntity->getUserId());
$user->setName($formEntity->getUserName());
$user->setEmail($formEntity->getUserEmail());
$user->setIsEnabled($formEntity->isEnabled());

// and persist user in database
```
 

## Composer
composer require "eureka/component-validation"

## Installation

You can install the component (for testing) with the following command:
```bash
make install
```

## Update

You can update the component (for testing) with the following command:
```bash
make update
```


## Testing & CI (Continuous Integration)

You can run tests on your side with following commands:
```bash
make php/tests   # run tests with coverage
make php/test    # run tests with coverage
make php/testdox # run tests without coverage reports but with prettified output
```

You also can run code style check or code style fixes with following commands:
```bash
make php/check   # run checks on check style
make php/fix     # run check style auto fix
```

To perform a static analyze of your code (with phpstan, lvl 9 at default), you can use the following command:
```bash
make php/analyze # Same as phpstan but with CLI output as table
```

To ensure you code still compatible with current supported version and futures versions of php, you need to
run the following commands (both are required for full support):
```bash
make php/min-compatibility # run compatibility check on current minimal version of php we support
make php/max-compatibility # run compatibility check on last version of php we will support in future
```

And the last "helper" commands, you can run before commit and push is:
```bash
make ci
```
This command clean the previous reports, install component if needed and run tests (with coverage report),
check the code style and check the php compatibility check, as it would be done in our CI.

## Contributing

See the [CONTRIBUTING](CONTRIBUTING.md) file.

## License

This project is currently under The MIT License (MIT). See [LICENCE](LICENSE) file for more information.
