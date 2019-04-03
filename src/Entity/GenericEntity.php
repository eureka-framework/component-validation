<?php

/*
 * Copyright (c) Deezer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Entity;

use Eureka\Component\Validation\Exception\ValidationException;
use Eureka\Component\Validation\ValidatorFactoryInterface;

/**
 * Class EntityGeneric
 *
 * @author Romain Cottard
 */
class GenericEntity implements \Iterator
{
    /** @var string[] $keys List of data keys */
    private $keys = [];

    /** @var string $key Current data key */
    private $key = '';

    /** @var string[] $errors */
    private $errors = [];

    /** @var array $data */
    protected $data = [];

    /** @var array $config Validator config */
    protected $validatorConfig = [];

    /** @var ValidatorFactoryInterface $validatorFactory */
    protected $validatorFactory;

    /**
     * GenericEntity constructor.
     *
     * @param ValidatorFactoryInterface $validatorFactory
     * @param array $validatorConfig
     * @param array $data
     */
    public function __construct(ValidatorFactoryInterface $validatorFactory, array $validatorConfig, array $data = [])
    {
        $this->validatorFactory = $validatorFactory;

        foreach ($validatorConfig as $name => $config) {
            $this->validatorConfig[self::toCamelCase($name)] = $config;
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
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param  array $data
     * @return $this
     */
    public function setFromArray(array $data): self
    {
        foreach ($data as $name => $value) {
            try {
                $this->set(self::toCamelCase($name), $value);
            } catch (ValidationException $exception) {
                $this->errors[$name] = $exception->getMessage();
            }
        }

        return $this;
    }

    /**
     * Magic method to have getters & setters for generic entity.
     *
     * @param  string $name
     * @param  array $arguments
     * @return $this|mixed|null
     * @throws \LogicException
     */
    public function __call(string $name, $arguments)
    {
        $prefixOriginal  = substr($name, 0, 3);
        $methodOriginal  = substr($name, 3);
        $prefixAlternate = substr($name, 0, 2);
        $methodAlternate = substr($name, 2);

        switch (true) {
            case $prefixAlternate === 'in':
            case $prefixAlternate === 'is':
                return $this->get($methodAlternate);
            case $prefixOriginal === 'has':
            case $prefixOriginal === 'get':
                return $this->get($methodOriginal);
            case $prefixOriginal === 'set':
                return $this->set($methodOriginal, ...$arguments);
            default:
                throw new \LogicException('Invalid method name.');
        }
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->data[$this->key];
    }

    /**
     * @inheritdoc
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * @inheritdoc
     */
    public function next(): void
    {
        $this->key = next($this->keys);
    }

    /**
     * @inheritdoc
     */
    public function rewind(): void
    {
        $this->key = reset($this->keys);
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return ($this->keys !== false);
    }

    /**
     * @param  string $name
     * @param  mixed $value
     * @return $this
     */
    protected function set(string $name, $value): self
    {
        if (!in_array($name, $this->keys)) {
            $this->keys[] = $name;
        }

        $this->data[$name] = $value;

        if (isset($this->validatorConfig[$name])) {
            $config    = $this->validatorConfig[$name];
            $validator = $this->validatorFactory->getValidator($config['type'] ?? 'string');
            $validator->validate($value, $config['options'] ?? []);
        }

        return $this;
    }

    /**
     * @param  string $name
     * @return mixed|null
     */
    protected function get(string $name)
    {
        if (!isset($this->data[$name])) {
            return null;
        }

        return $this->data[$name];
    }

    /**
     * @param  string $name
     * @return string
     */
    protected static function toCamelCase(string $name)
    {
        return strtr(ucwords(strtr(strtolower($name), ['_' => ' ', '.' => '_ ', '\\' => '_ '])), [' ' => '']);
    }
}
