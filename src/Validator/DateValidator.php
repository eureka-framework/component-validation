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
 * @phpstan-import-type OptionsType from ValidatorInterface
 */
class DateValidator extends AbstractValidator implements ValidatorInterface
{
    use DateTimeTrait;

    /**
     * @param OptionsType $options
     */
    public function validate(mixed $value, array $options = [], ?int $flags = null): ?string
    {
        if (!\is_string($value)) {
            throw new ValidationException('Value must be a string');
        }

        return $this->getDateOrDefault($value, $options, 'Y-m-d');
    }
}
