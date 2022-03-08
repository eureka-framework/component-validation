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
 * Class ValidatorEntityFactoryInterface
 *
 * @author Romain Cottard
 */
interface ValidatorEntityFactoryInterface
{
    /**
     * @param array<string,mixed> $config
     * @param array<string,mixed> $data
     * @return Entity\GenericEntity
     */
    public function createGeneric(array $config, array $data = []): Entity\GenericEntity;
}
