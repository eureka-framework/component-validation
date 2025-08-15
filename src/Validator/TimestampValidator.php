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
class TimestampValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @param OptionsType $options
     */
    public function validate(mixed $value, array $options = [], ?int $flags = null): ?int
    {
        $options['min_range'] = 0;
        $options['max_range'] = 2147483647;

        $filteredValue = \filter_var($value, \FILTER_VALIDATE_INT, $this->getOptions($options, $flags));

        if ($filteredValue === false) {
            throw new ValidationException('Given value is not a valid integer!');
        }

        if ($filteredValue !== null && !\is_int($filteredValue)) {
            throw new ValidationException('Optional value must be a string or null!');
        }

        return $filteredValue;
    }
}
