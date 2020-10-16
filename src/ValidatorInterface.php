<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation;

/**
 * Interface Validator for Validator classes
 *
 * @author Romain Cottard
 */
interface ValidatorInterface
{
    /**
     * @param  mixed $value Value to validate
     * @param  array $options
     * @param  int|null   $flags Validation flag. If null, use default flag or validator default flag.
     * @return mixed Return value
     * @throws \RuntimeException
     */
    public function validate($value, array $options = [], int $flags = null);
}
