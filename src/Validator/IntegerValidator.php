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
class IntegerValidator extends AbstractValidator implements ValidatorInterface
{
    public const array TINYINT_SIGNED     = ['min_range' => -128, 'max_range' => 127];
    public const array TINYINT_UNSIGNED   = ['min_range' => 0, 'max_range' => 255];
    public const array SMALLINT_SIGNED    = ['min_range' => -32_768, 'max_range' => 32_767];
    public const array SMALLINT_UNSIGNED  = ['min_range' => 0, 'max_range' => 65_535];
    public const array MEDIUMINT_SIGNED   = ['min_range' => -8_388_608, 'max_range' => 8_388_607];
    public const array MEDIUMINT_UNSIGNED = ['min_range' => 0, 'max_range' => 16_777_215];
    public const array INT_SIGNED         = ['min_range' => -2_147_483_648, 'max_range' => 2_147_483_647];
    public const array INT_UNSIGNED       = ['min_range' => 0, 'max_range' => 4_294_967_295];
    public const array BIGINT_SIGNED      = ['min_range' => -9_223_372_036_854_775_808, 'max_range' => 9_223_372_036_854_775_807];
    public const array BIGINT_UNSIGNED    = ['min_range' => 0, 'max_range' => PHP_INT_MAX]; // PHP_INT_MAX is platform dependent, but usually it is 9_223_372_036_854_775_807 on 64-bit systems

    /**
     * @param OptionsType $options
     */
    public function validate(mixed $value, array $options = [], ?int $flags = null): ?int
    {
        $filteredValue = \filter_var($value, FILTER_VALIDATE_INT, $this->getOptions($options, $flags));

        if ($filteredValue === false) {
            throw new ValidationException('Given value is not a valid integer!');
        }

        if ($filteredValue !== null && !\is_int($filteredValue)) {
            throw new ValidationException('Optional value must be a float or null!');
        }

        return $filteredValue;
    }
}
