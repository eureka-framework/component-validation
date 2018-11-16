<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation;

use Eureka\Component\Validation\Validator;

/**
 * Validator factory
 *
 * @author Romain Cottard
 */
class ValidatorFactory
{
    /** @var array $validators */
    protected static $validators = [];

    /**
     * @param  string $type
     * @return \Eureka\Component\Validation\ValidatorInterface
     * @throws \LogicException
     */
    public function getValidator($type)
    {
        switch ($type)
        {
            case 'boolean':
                return $this->getBooleanValidator();
                break;
            case 'datetime':
                return $this->getDateTimeValidator();
                break;
            case 'date':
                return $this->getDateValidator();
                break;
            case 'time':
                return $this->getTimeValidator();
                break;
            case 'timestamp':
                return $this->getTimestampValidator();
                break;
            case 'email':
                return $this->getEmailValidator();
                break;
            case 'float':
            case 'double':
            case 'decimal':
                return $this->getFloatValidator();
                break;
            case 'integer':
                return $this->getIntegerValidator();
                break;
            case 'null':
            case '~':
                return $this->getNullValidator();
                break;
            case 'ip':
                return $this->getIpValidator();
                break;
            case 'regexp':
                return $this->getRegexpValidator();
                break;
            case 'url':
                return $this->getUrlValidator();
                break;
            case 'string':
                return $this->getStringValidator();
                break;
            default:
                throw new \LogicException('Invalid validator type (type: ' . $type . ')');
        }
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getBooleanValidator()
    {
        if (!isset(self::$validators['BooleanValidator'])) {
            self::$validators['BooleanValidator'] = new Validator\BooleanValidator();
        }

        return self::$validators['BooleanValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getDateTimeValidator()
    {
        if (!isset(self::$validators['DateTimeValidator'])) {
            self::$validators['DateTimeValidator'] = new Validator\DateTimeValidator();
        }

        return self::$validators['DateTimeValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getDateValidator()
    {
        if (!isset(self::$validators['DateValidator'])) {
            self::$validators['DateValidator'] = new Validator\DateValidator();
        }

        return self::$validators['DateValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getTimeValidator()
    {
        if (!isset(self::$validators['TimeValidator'])) {
            self::$validators['TimeValidator'] = new Validator\TimeValidator();
        }

        return self::$validators['TimeValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getTimestampValidator()
    {
        if (!isset(self::$validators['TimestampValidator'])) {
            self::$validators['TimestampValidator'] = new Validator\TimestampValidator();
        }

        return self::$validators['TimestampValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getEmailValidator()
    {
        if (!isset(self::$validators['EmailValidator'])) {
            self::$validators['EmailValidator'] = new Validator\EmailValidator();
        }

        return self::$validators['EmailValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getFloatValidator()
    {
        if (!isset(self::$validators['FloatValidator'])) {
            self::$validators['FloatValidator'] = new Validator\FloatValidator();
        }

        return self::$validators['FloatValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getIntegerValidator()
    {
        if (!isset(self::$validators['IntegerValidator'])) {
            self::$validators['IntegerValidator'] = new Validator\IntegerValidator();
        }

        return self::$validators['IntegerValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getNullValidator()
    {
        if (!isset(self::$validators['NullValidator'])) {
            self::$validators['NullValidator'] = new Validator\NullValidator();
        }

        return self::$validators['NullValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getIpValidator()
    {
        if (!isset(self::$validators['IpValidator'])) {
            self::$validators['IpValidator'] = new Validator\IpValidator();
        }

        return self::$validators['IpValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getRegexpValidator()
    {
        if (!isset(self::$validators['RegexpValidator'])) {
            self::$validators['RegexpValidator'] = new Validator\RegexpValidator();
        }

        return self::$validators['RegexpValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getUrlValidator()
    {
        if (!isset(self::$validators['UrlValidator'])) {
            self::$validators['UrlValidator'] = new Validator\UrlValidator();
        }

        return self::$validators['UrlValidator'];
    }

    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getStringValidator()
    {
        if (!isset(self::$validators['StringValidator'])) {
            self::$validators['StringValidator'] = new Validator\StringValidator();
        }

        return self::$validators['StringValidator'];
    }
}
