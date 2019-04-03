<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation;

/**
 * Interface Validator Factory for Validator Factory classes
 *
 * @author Romain Cottard
 */
interface ValidatorFactoryInterface
{
    /**
     * @param  string $type
     * @return ValidatorInterface
     */
    public function getValidator($type): ValidatorInterface;
}
