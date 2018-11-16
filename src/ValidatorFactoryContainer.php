<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validator;

use Eureka\Component\Container\Exception\NotFoundException;
use Eureka\Component\Validation\Entity\FormEntity;
use Eureka\Component\Validation\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Interface RepositoryInterface
 *
 * @author Romain Cottard
 */
class ValidatorFactoryContainer implements ContainerInterface
{
    /** @var \Eureka\Component\Validation\ValidatorFactoryInterface $validatorFactory */
    private $validatorFactory;

    /** @var array $validatorConfigs */
    private $validatorConfigs;

    /**
     * ValidatorFactoryContainer constructor.
     *
     * @param \Eureka\Component\Validation\ValidatorFactoryInterface $validatorFactory
     * @param array $validatorConfigs
     */
    public function __construct(ValidatorFactoryInterface $validatorFactory, array $validatorConfigs = [])
    {
        $this->validatorFactory = $validatorFactory;
        $this->validatorConfigs = $validatorConfigs;
    }

    /**
     * @inheritdoc
     */
    public function has($type)
    {
        try {
            $this->get($type);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function get($type)
    {
        try {
            if ($type === 'factory') {
                return $this->validatorFactory;
            }

            if ($type === 'config') {
                return $this->validatorConfigs;
            }

            return $this->validatorFactory->getValidator($type);
        } catch (\Exception $exception) {
            throw new NotFoundException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
