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
 * Class IpValidator
 *
 * @author Romain Cottard
 */
class IpValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, array $options = [], $flags = null)
    {
        $flags = ($flags === null ? FILTER_FLAG_IPV4 : $flags);

        $filteredValue = filter_var($value, FILTER_VALIDATE_IP, $this->getOptions($options, $flags));

        if (false === $filteredValue) {
            throw new ValidationException('Given value is not a valid IP!');
        }

        return $filteredValue;
    }
}
