<?php

/*
 * Copyright (c) Deezer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Entity;

use Eureka\Component\Validation\ValidatorFactory;

/**
 * Class FormEntity
 *
 * @author Romain Cottard
 */
class FormEntity
{
    /** @var array data */
    protected $data = [];

    /** @var ValidatorFactory|null $validatorFactory */
    protected $validatorFactory = null;

    /**
     * FormEntity constructor.
     *
     * @param array $data
     * @param \Eureka\Component\Validation\ValidatorFactory $validatorFactory
     */
    public function __construct($data, ValidatorFactory $validatorFactory = null)
    {
        foreach ($data as $name => $value) {
            $this->set(self::toCamelCase($name), $value);
        }

        $this->validatorFactory;
    }

    /**
     * Magic method to have getters & setters for form entity.
     *
     * @param  string $name
     * @param  array $arguments
     * @return $this|mixed|null
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
                throw new \RuntimeException('Invalid method name.');
        }
    }

    /**
     * @param  string $name
     * @param  mixed $value
     * @return $this
     */
    protected function set($name, $value)
    {
        $this->data[$name] = $value;

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
