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
 * Class DomainValidator
 *
 * @author Romain Cottard
 */
class DomainValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @param  mixed $value
     * @param  array<string,string|float|int|bool|null> $options
     * @param  int|null $flags Not used here.
     * @return mixed Return value
     */
    public function validate($value, array $options = [], ?int $flags = FILTER_DEFAULT)
    {
        $filteredValue = filter_var($value, FILTER_VALIDATE_DOMAIN, $this->getOptions($options, $flags));

        if (false === $filteredValue) {
            throw new ValidationException('Given value is not a valid domain!');
        }

        return $filteredValue;
    }
}
