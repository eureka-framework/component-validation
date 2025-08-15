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
trait DateTimeTrait
{
    /**
     * @param OptionsType $options
     */
    protected function getDateOrDefault(string $value, array $options, string $defaultFormat): ?string
    {
        if (!isset($options['format'])) {
            $options['format'] = $defaultFormat;
        }

        if (!isset($options['format_output'])) {
            $options['format_output'] = $defaultFormat;
        }

        $date = \DateTimeImmutable::createFromFormat((string) $options['format'], $value);

        if (! $date instanceof \DateTimeImmutable) {
            if (!array_key_exists('default', $options)) {
                throw new ValidationException(
                    'Given value is not a valid date or time according to following format: "' . $options['format'] . '"!',
                );
            }

            return ($options['default'] !== null ? (string) $options['default'] : null);
        }

        return $date->format((string) $options['format_output']);
    }
}
