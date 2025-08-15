<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation\Validator;

use Eureka\Component\Validation\Exception\ValidationException;
use Eureka\Component\Validation\ValidatorInterface;

/**
 * @phpstan-import-type OptionsType from ValidatorInterface
 */
class EmailValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @param OptionsType $options
     */
    public function validate(mixed $value, array $options = [], ?int $flags = FILTER_DEFAULT): ?string
    {
        $filteredValue = \filter_var($value, FILTER_VALIDATE_EMAIL, $this->getOptions($options, $flags));

        if ($filteredValue === false) {
            throw new ValidationException('Given value is not a valid email!');
        }

        if ($filteredValue !== null && !\is_string($filteredValue)) {
            throw new ValidationException('Optional value must be a string or null!');
        }

        return $filteredValue;
    }
}
