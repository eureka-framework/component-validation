<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation\Entity;

use Eureka\Component\Validation\ValidatorEntityFactoryInterface;
use Eureka\Component\Validation\ValidatorFactoryInterface;

/**
 * Class ValidatorEntityFactory
 *
 * @author Romain Cottard
 */
class ValidatorEntityFactory implements ValidatorEntityFactoryInterface
{
    /** @var ValidatorFactoryInterface $validatorFactory */
    protected ValidatorFactoryInterface $validatorFactory;

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
     * @param array<string, array<string, array<string, int|float|bool|string|null>|int|float|bool|string|null>> $config
     * @param array<string, int|float|bool|string|null> $data
     * @return GenericEntity
     */
    public function createGeneric(array $config, array $data = []): GenericEntity
    {
        return new GenericEntity($this->validatorFactory, $config, $data);
    }
}
