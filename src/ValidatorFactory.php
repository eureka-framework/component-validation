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
class ValidatorFactory implements ValidatorFactoryInterface
{
    /** @var ValidatorInterface[] $validators */
    protected static $validators = [];

    /**
     * @param  string $type
     * @return ValidatorInterface
     * @throws \LogicException
     */
    public function getValidator($type): ValidatorInterface
    {
        switch ((string) $type) {
            case 'boolean':
                return $this->getBooleanValidator();
            case 'datetime':
                return $this->getDateTimeValidator();
            case 'date':
                return $this->getDateValidator();
            case 'time':
                return $this->getTimeValidator();
            case 'timestamp':
                return $this->getTimestampValidator();
            case 'email':
                return $this->getEmailValidator();
            case 'float':
            case 'double':
            case 'decimal':
                return $this->getFloatValidator();
            case 'integer':
                return $this->getIntegerValidator();
            case 'null':
            case '~':
            case '':
                return $this->getNullValidator();
            case 'ip':
                return $this->getIpValidator();
            case 'regexp':
                return $this->getRegexpValidator();
            case 'url':
                return $this->getUrlValidator();
            case 'string':
                return $this->getStringValidator();
            default:
                throw new \LogicException('Invalid validator type (type: ' . $type . ')');
        }
    }

    /**
     * @return Validator\BooleanValidator
     */
    public function getBooleanValidator(): Validator\BooleanValidator
    {
        if (!isset(self::$validators['BooleanValidator'])) {
            self::$validators['BooleanValidator'] = new Validator\BooleanValidator();
        }

        return self::$validators['BooleanValidator'];
    }

    /**
     * @return Validator\DateTimeValidator
     */
    public function getDateTimeValidator(): Validator\DateTimeValidator
    {
        if (!isset(self::$validators['DateTimeValidator'])) {
            self::$validators['DateTimeValidator'] = new Validator\DateTimeValidator();
        }

        return self::$validators['DateTimeValidator'];
    }

    /**
     * @return Validator\DateValidator
     */
    public function getDateValidator(): Validator\DateValidator
    {
        if (!isset(self::$validators['DateValidator'])) {
            self::$validators['DateValidator'] = new Validator\DateValidator();
        }

        return self::$validators['DateValidator'];
    }

    /**
     * @return Validator\TimeValidator
     */
    public function getTimeValidator(): Validator\TimeValidator
    {
        if (!isset(self::$validators['TimeValidator'])) {
            self::$validators['TimeValidator'] = new Validator\TimeValidator();
        }

        return self::$validators['TimeValidator'];
    }

    /**
     * @return Validator\TimestampValidator
     */
    public function getTimestampValidator(): Validator\TimestampValidator
    {
        if (!isset(self::$validators['TimestampValidator'])) {
            self::$validators['TimestampValidator'] = new Validator\TimestampValidator();
        }

        return self::$validators['TimestampValidator'];
    }

    /**
     * @return Validator\EmailValidator
     */
    public function getEmailValidator(): Validator\EmailValidator
    {
        if (!isset(self::$validators['EmailValidator'])) {
            self::$validators['EmailValidator'] = new Validator\EmailValidator();
        }

        return self::$validators['EmailValidator'];
    }

    /**
     * @return Validator\FloatValidator
     */
    public function getFloatValidator(): Validator\FloatValidator
    {
        if (!isset(self::$validators['FloatValidator'])) {
            self::$validators['FloatValidator'] = new Validator\FloatValidator();
        }

        return self::$validators['FloatValidator'];
    }

    /**
     * @return Validator\IntegerValidator
     */
    public function getIntegerValidator(): Validator\IntegerValidator
    {
        if (!isset(self::$validators['IntegerValidator'])) {
            self::$validators['IntegerValidator'] = new Validator\IntegerValidator();
        }

        return self::$validators['IntegerValidator'];
    }

    /**
     * @return Validator\NullValidator
     */
    public function getNullValidator(): Validator\NullValidator
    {
        if (!isset(self::$validators['NullValidator'])) {
            self::$validators['NullValidator'] = new Validator\NullValidator();
        }

        return self::$validators['NullValidator'];
    }

    /**
     * @return Validator\IpValidator
     */
    public function getIpValidator(): Validator\IpValidator
    {
        if (!isset(self::$validators['IpValidator'])) {
            self::$validators['IpValidator'] = new Validator\IpValidator();
        }

        return self::$validators['IpValidator'];
    }

    /**
     * @return Validator\RegexpValidator
     */
    public function getRegexpValidator(): Validator\RegexpValidator
    {
        if (!isset(self::$validators['RegexpValidator'])) {
            self::$validators['RegexpValidator'] = new Validator\RegexpValidator();
        }

        return self::$validators['RegexpValidator'];
    }

    /**
     * @return Validator\UrlValidator
     */
    public function getUrlValidator(): Validator\UrlValidator
    {
        if (!isset(self::$validators['UrlValidator'])) {
            self::$validators['UrlValidator'] = new Validator\UrlValidator();
        }

        return self::$validators['UrlValidator'];
    }

    /**
     * @return Validator\StringValidator
     */
    public function getStringValidator(): Validator\StringValidator
    {
        if (!isset(self::$validators['StringValidator'])) {
            self::$validators['StringValidator'] = new Validator\StringValidator();
        }

        return self::$validators['StringValidator'];
    }
}
