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
 * @phpstan-type OptionsType array<string,string|null|int|float|bool>
 */
interface ValidatorInterface
{
    /**
     * @param mixed $value Value to validate
     * @param OptionsType $options
     * @param int|null   $flags Validation flag. If null, use default flag or validator default flag.
     * @throws \RuntimeException
     */
    public function validate(mixed $value, array $options = [], ?int $flags = null): string|float|int|bool|null;
}
