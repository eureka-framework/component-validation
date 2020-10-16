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
 * Class DateValidator
 *
 * @author Romain Cottard
 */
class DateValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @param  mixed $value
     * @param  array $options
     * @param  int|null $flags Not used here.
     * @return mixed Return value
     */
    public function validate($value, array $options = [], ?int $flags = null)
    {
        if (!isset($options['format'])) {
            $options['format'] = 'Y-m-d';
        }

        if (!isset($options['format_output'])) {
            $options['format_output'] = 'Y-m-d';
        }

        $date = \DateTimeImmutable::createFromFormat($options['format'], $value);

        if (! $date instanceof \DateTimeImmutable) {
            if (!array_key_exists('default', $options)) {
                throw new ValidationException('Given value is not a valid date according to following format: "' . $options['format'] . '"!');
            }

            return $options['default'];
        }

        return $date->format($options['format_output']);
    }
}
