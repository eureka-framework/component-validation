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
 * Class TimestampValidator
 *
 * @author Romain Cottard
 */
class TimestampValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, array $options = [], $flags = null)
    {
        $options['min_range'] = 0;
        $options['max_range'] = 2147483647;

        $filteredValue = filter_var($value, FILTER_VALIDATE_INT, $this->getOptions($options, $flags));

        if (false === $filteredValue) {
            throw new ValidationException('Given value is not a valid integer!');
        }

        return $filteredValue;
    }
}
