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
class NullValidator extends AbstractValidator implements ValidatorInterface
{
    /**
     * @param OptionsType $options
     */
    public function validate(mixed $value, array $options = [], ?int $flags = null): null
    {
        if ($value !== null) {
            throw new ValidationException('Given value is not null!');
        }

        return null;
    }
}
