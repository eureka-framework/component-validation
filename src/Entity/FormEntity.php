<?php

/*
 * Copyright (c) Deezer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Entity;

use Eureka\Component\Validation\Exception\ValidationException;
use Eureka\Component\Validation\ValidatorFactory;
use Eureka\Component\Validation\ValidatorFactoryInterface;

/**
 * Class FormEntity
 *
 * @author Romain Cottard
 */
class FormEntity implements \Iterator
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

    /** @var ValidatorFactory|null $validatorFactory */
    protected $validatorFactory = null;

    /**
     * FormEntity constructor.
     *
     * @param \Eureka\Component\Validation\ValidatorFactoryInterface $validatorFactory
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
    public function isValid()
    {
        return empty($this->errors);
    }

    /**
     * @return string[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param  array $data
     * @return void
     */
    public function setFromArray($data)
    {
        foreach ($data as $name => $value) {
            try {
                $this->__call(self::toCamelCase($name), $value);
            } catch (ValidationException $exception) {
                $this->errors[$name] = $exception->getMessage();
            }
        }
    }

    /**
     * Magic method to have getters & setters for form entity.
     *
     * @param  string $name
     * @param  array $arguments
     * @return $this|mixed|null
     * @throws \LogicException
     */
    public function __call($name, $arguments)
    {
        $prefixOriginal  = substr($name, 0, 3);
        $methodOriginal  = substr($name, 3);
        $prefixAlternate = substr($name, 0, 2);
        $methodAlternate = substr($name, 2);

        switch (true) {
            case $prefixAlternate === 'in':
            case $prefixAlternate === 'is':
                return $this->get($methodAlternate);
                break;
            case $prefixOriginal === 'has':
            case $prefixOriginal === 'get':
                return $this->get($methodOriginal);
                break;
            case $prefixOriginal === 'set':
                return $this->set($methodOriginal, ...$arguments);
                break;
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
    public function key()
    {
        return $this->key;
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->key = next($this->keys);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
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
    protected function set($name, $value)
    {
        if (!in_array($name, $this->keys)) {
            $this->keys[] = $name;
        }

        if (isset($this->validatorConfig[$name])) {
            $config    = $this->validatorConfig[$name];
            $validator = $this->validatorFactory->getValidator(isset($config['type']) ? $config['type'] : 'string');
            $validator->validate($value, $config['options'] ? $config['options'] : []);
        }

        return $this;
    }

    /**
     * @param  string $name
     * @return mixed|null
     */
    protected function get($name)
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
    protected static function toCamelCase($name)
    {
        return strtr(ucwords(strtr(strtolower($name), ['_' => ' ', '.' => '_ ', '\\' => '_ ' ])), [' ' => '']);
    }
}
