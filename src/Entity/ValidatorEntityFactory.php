<?php

/*
 * Copyright (c) Deezer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Entity;

use Eureka\Component\Validation\ValidatorEntityFactoryInterface;
use Eureka\Component\Validation\ValidatorFactoryInterface;

/**
 * Class EntityFactory
 *
 * @author Romain Cottard
 */
class ValidatorEntityFactory implements ValidatorEntityFactoryInterface
{
    /** @var ValidatorFactoryInterface $validatorFactory */
    protected $validatorFactory;

    /**
     * EntityFactory constructor.
     *
     * @param ValidatorFactoryInterface $validatorFactory
     */
    public function __construct(ValidatorFactoryInterface $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * @param array $config
     * @param array $data
     * @return GenericEntity
     */
    public function createGeneric(array $config, array $data = []): GenericEntity
    {
        return new GenericEntity($this->validatorFactory, $config, $data);
    }
}
