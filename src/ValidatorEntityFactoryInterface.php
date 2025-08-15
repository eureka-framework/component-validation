<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation;

interface ValidatorEntityFactoryInterface
{
    /**
     * @param array<string, array<string, array<string, int|float|bool|string|null>|int|float|bool|string|null>> $config
     * @param array<string, int|float|bool|string|null> $data
     * @return Entity\GenericEntity
     */
    public function createGeneric(array $config, array $data = []): Entity\GenericEntity;
}
