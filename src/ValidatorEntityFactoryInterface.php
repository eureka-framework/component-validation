<?php

/*
 * Copyright (c) Deezer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation;

/**
 * Class ValidatorEntityFactoryInterface
 *
 * @author Romain Cottard
 */
interface ValidatorEntityFactoryInterface
{
    /**
     * @param array $config
     * @param array $data
     * @return Entity\GenericEntity
     */
    public function createGeneric(array $config, array $data = []): Entity\GenericEntity;
}
