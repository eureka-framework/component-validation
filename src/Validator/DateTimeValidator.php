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
 * Class DateTimeValidator
 *
 * @author Romain Cottard
 */
class DateTimeValidator extends AbstractValidator implements ValidatorInterface
{
    use DateTimeTrait;

    /**
     * @param  string $value
     * @param  array<string,string> $options
     * @param  int|null $flags Not used here.
     * @return string|null Return value
     */
    public function validate($value, array $options = [], ?int $flags = null): ?string
    {
        return $this->getDateOrDefault($value, $options, 'Y-m-d H:i:s');
    }
}
