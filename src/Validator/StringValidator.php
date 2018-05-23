<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Validator;

use Eureka\Component\Validation\Exception\ValidationException;
use Eureka\Component\Validation\ValidatorInterface;

/**
 * Class StringValidator
 *
 * @author Romain Cottard
 */
class StringValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, array $options = [], $flags = null)
    {
        $default = isset($options['default']) ? $options['default'] : null;

        //~ Validate type
        if (false === is_string($value)) {
            if (empty($default)) {
                throw new ValidationException('Given value is not a valid string!');
            }

            return $value;
        }

        //~ Validate min length
        if (isset($options['min_length']) && mb_strlen($value) < (int) $options['min_length']) {
            if (empty($default)) {
                throw new ValidationException('String must have at least ' . $options['min_length'] . ' characters!');
            }

            return $value;
        }

        //~ Validate min length
        if (isset($options['max_length']) && mb_strlen($value) > (int) $options['max_length']) {
            if (empty($default)) {
                throw new ValidationException('String must have maximum ' . $options['max_length'] . ' characters!');
            }

            return $value;
        }

        return $value;
    }
}
