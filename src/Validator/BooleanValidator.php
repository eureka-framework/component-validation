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
 * Class BooleanValidator
 *
 * @author Romain Cottard
 */
class BooleanValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @param mixed $value
     * @param array $options
     * @param int|null $flags
     * @return mixed
     */
    public function validate($value, array $options = [], ?int $flags = null)
    {
        if ($flags === null) {
            $flags = !array_key_exists('default', $options) ? FILTER_NULL_ON_FAILURE : FILTER_DEFAULT;
        }

        $filteredValue = filter_var($value, FILTER_VALIDATE_BOOLEAN, $this->getOptions($options, $flags));

        if (null === $filteredValue) {
            throw new ValidationException('Given value is not a valid boolean!');
        }

        return $filteredValue;
    }
}
