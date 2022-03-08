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
 * Class StringValidator
 *
 * @author Romain Cottard
 */
class StringValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @param  mixed $value
     * @param  array<string,string|float|int|bool|null> $options
     * @param  int|null $flags Not used here.
     * @return mixed Return value
     */
    public function validate($value, array $options = [], ?int $flags = null)
    {
        $default = array_key_exists('default', $options) ? $options['default'] : false;

        //~ Validate type
        if (false === is_string($value)) {
            if ($default === false) {
                throw new ValidationException('Given value is not a string!');
            }

            return $default;
        }

        //~ Validate min length
        if (isset($options['min_length']) && mb_strlen($value) < (int) $options['min_length']) {
            if ($default === false) {
                throw new ValidationException('String must have at least ' . $options['min_length'] . ' characters!');
            }

            return $default;
        }

        //~ Validate max length
        if (isset($options['max_length']) && mb_strlen($value) > (int) $options['max_length']) {
            if ($default === false) {
                throw new ValidationException('String must have maximum ' . $options['max_length'] . ' characters!');
            }

            return $default;
        }

        return $value;
    }
}
