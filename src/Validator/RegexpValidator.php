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
 * Class RegexpValidator
 *
 * @author Romain Cottard
 */
class RegexpValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @param  mixed $value
     * @param  array $options
     * @param  int|null $flags Not used here.
     * @return mixed Return value
     */
    public function validate($value, array $options = [], ?int $flags = null)
    {
        $filteredValue = filter_var($value, FILTER_VALIDATE_REGEXP, $this->getOptions($options, FILTER_DEFAULT));

        if (false === $filteredValue) {
            throw new ValidationException('Given value is not a valid value according to the given regexp!');
        }

        return $filteredValue;
    }
}
