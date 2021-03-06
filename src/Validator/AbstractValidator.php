<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation\Validator;

/**
 * Class BooleanValidator
 *
 * @author Romain Cottard
 */
class AbstractValidator
{
    /**
     * @param  array $options
     * @param  int|null $flags
     * @return array
     */
    protected function getOptions(array $options = [], ?int $flags = FILTER_DEFAULT): array
    {
        return [
            'options' => $options,
            'flags'   => $flags,
        ];
    }
}
