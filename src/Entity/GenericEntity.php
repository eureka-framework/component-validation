<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation\Entity;

use Eureka\Component\Validation\Exception\ValidationException;
use Eureka\Component\Validation\ValidatorFactoryInterface;

/**
 * Class EntityGeneric
 *
 * @author Romain Cottard
 */
class GenericEntity
{
    /** @var string[] $errors */
    private array $errors = [];

    /** @var array<string, int|float|bool|string|null> $data */
    protected array $data = [];

    /** @var array<string, array<string, array<string, int|float|bool|string|null>|int|float|bool|string|null>> $validatorConfig Validator config
     */
    protected array $validatorConfig = [];

    /** @var ValidatorFactoryInterface $validatorFactory */
    protected ValidatorFactoryInterface $validatorFactory;

    /**
     * GenericEntity constructor.
     *
     * @param ValidatorFactoryInterface $validatorFactory
     * @param array<string, array<string, array<string, int|float|bool|string|null>|int|float|bool|string|null>> $validatorConfig
     * @param array<string, int|float|bool|string|null> $data
     */
    public function __construct(ValidatorFactoryInterface $validatorFactory, array $validatorConfig, array $data = [])
    {
        $this->validatorFactory = $validatorFactory;

        foreach ($validatorConfig as $name => $config) {
            $this->validatorConfig[self::toPascalCase($name)] = $config;
        }

        if (!empty($data)) {
            $this->setFromArray($data);
        }
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * @param string $name
     * @param string $error
     * @return GenericEntity
     */
    public function addError(string $name, string $error): self
    {
        $this->errors[$name] = $error;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param  array<string, int|float|bool|string|null> $data
     * @return $this
     */
    public function setFromArray(array $data): self
    {
        foreach ($data as $name => $value) {
            try {
                $this->set(self::toPascalCase($name), $value);
            } catch (ValidationException $exception) {
                $this->addError($name, $exception->getMessage());
            }
        }

        return $this;
    }

    /**
     * Magic method to have getters & setters for generic entity.
     *
     * @param  string $name
     * @param  array<int, int|float|bool|string|null> $arguments
     * @return $this|int|float|bool|string|null
     * @throws \LogicException
     */
    public function __call(string $name, array $arguments)
    {
        $prefixOriginal  = substr($name, 0, 3);
        $prefixAlternate = substr($name, 0, 2);

        switch (true) {
            case $prefixAlternate === 'in':
            case $prefixAlternate === 'is':
            case $prefixOriginal === 'has':
                return $this->get($name);
            case $prefixOriginal === 'get':
                return $this->get(substr($name, 3));
            case $prefixOriginal === 'set':
                return $this->set(substr($name, 3), ...$arguments);
            default:
                throw new \LogicException('Invalid method name.');
        }
    }

    /**
     * @param  string $name
     * @param  int|float|bool|string|null $value
     * @return $this
     */
    protected function set(string $name, $value): self
    {
        $name = self::toPascalCase($name);

        $this->data[$name] = $value;

        if (isset($this->validatorConfig[$name]) && $value !== null) {
            $config    = $this->validatorConfig[$name];
            /** @var string $type */
            $type      = $config['type'] ?? 'string';
            /** @var array<string, int|float|bool|string|null> $options */
            $options   = $config['options'] ?? [];
            $validator = $this->validatorFactory->getValidator($type);
            $validator->validate($value, $options);
        }

        return $this;
    }

    /**
     * @param  string $name
     * @return int|float|bool|string|null
     */
    protected function get(string $name)
    {
        $name = self::toPascalCase($name);

        if (!isset($this->data[$name])) {
            return null;
        }

        return $this->data[$name];
    }

    /**
     * @param  string $name
     * @return string
     */
    protected static function toPascalCase(string $name): string
    {
        return strtr(ucwords(strtr($name, ['_' => ' ', '.' => '_ ', '\\' => '_ '])), [' ' => '']);
    }
}
