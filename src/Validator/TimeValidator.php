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
 * Class TimeValidator
 *
 * @author Romain Cottard
 */
class TimeValidator extends AbstractValidator implements ValidatorInterface
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
            $options['format'] = 'H:i:s';
        }

        if (!isset($options['format_output'])) {
            $options['format_output'] = 'H:i:s';
        }

        $date = \DateTimeImmutable::createFromFormat($options['format'], $value);

        if (! $date instanceof \DateTimeImmutable) {
            if (!array_key_exists('default', $options)) {
                throw new ValidationException('Given value is not a valid time according to following format: "' . $options['format'] . '"!');
            }

            return $options['default'];
        }

        return $date->format($options['format_output']);
    }
}
