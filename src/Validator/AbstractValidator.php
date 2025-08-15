<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation\Validator;

use Eureka\Component\Validation\ValidatorInterface;

/**
 * @phpstan-import-type OptionsType from ValidatorInterface
 */
class AbstractValidator
{
    /**
     * @param  OptionsType $options
     * @param  int|null $flags
     * @return array{options: OptionsType, flags: int|null}
     */
    protected function getOptions(array $options = [], ?int $flags = FILTER_DEFAULT): array
    {
        return [
            'options' => $options,
            'flags'   => $flags,
        ];
    }
}
