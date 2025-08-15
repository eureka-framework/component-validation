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
class StringValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @param OptionsType $options
     */
    public function validate(mixed $value, array $options = [], ?int $flags = null): ?string
    {
        $default    = \array_key_exists('default', $options) ? $options['default'] : false;
        $hasDefault = $default === null || \is_string($default);

        //~ Validate type
        if (!\is_string($value)) {
            if (!$hasDefault) {
                throw new ValidationException('Given value is not a string!');
            }

            return $default;
        }

        //~ Validate min length
        if (isset($options['min_length']) && \mb_strlen($value) < (int) $options['min_length']) {
            throw new ValidationException('String must have at least ' . $options['min_length'] . ' characters!');
        }

        //~ Validate max length
        if (isset($options['max_length']) && mb_strlen($value) > (int) $options['max_length']) {
            throw new ValidationException('String must have maximum ' . $options['max_length'] . ' characters!');
        }

        return $value;
    }
}
