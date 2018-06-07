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
 * Class DateTimeValidator
 *
 * @author Romain Cottard
 */
class DateTimeValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @param  string $value
     * @param  array $options
     * @param  int $flags Not used here.
     * @return string Return value
     */
    public function validate($value, array $options = [], $flags = null)
    {
        if (!isset($options['format'])) {
            $options['format'] = 'Y-m-d H:i:s';
        }

        if (!isset($options['format_output'])) {
            $options['format_output'] = 'Y-m-d H:i:s';
        }

        $date = \DateTimeImmutable::createFromFormat($options['format'], $value);

        if (! $date instanceof \DateTimeImmutable) {
            if (!array_key_exists('default', $options)) {
                throw new ValidationException('Given value is not a valid date time according to following format: "' . $options['format'] . '"!');
            }

            return $options['default'];
        }

        return $date->format($options['format_output']);
    }
}
