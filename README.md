# component-validation

[![Current version](https://img.shields.io/packagist/v/eureka/component-validation.svg?logo=composer)](https://packagist.org/packages/eureka/component-validation)
[![Supported PHP version](https://img.shields.io/static/v1?logo=php&label=PHP&message=7.4%20-%208.3&color=777bb4)](https://packagist.org/packages/eureka/component-validation)
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


## Testing

You can test the component with the following commands:
```bash
make phpcs
make tests
make testdox
```
