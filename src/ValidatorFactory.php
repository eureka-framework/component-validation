<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation;

use Eureka\Component\Validation\Validator;

/**
 * Validator factory
 *
 * @author Romain Cottard
 */
class ValidatorFactory implements ValidatorFactoryInterface
{
    /** @var ValidatorInterface[] $validators
     */
    protected static array $validators = [];

    /**
     * @param  string $type
     * @return ValidatorInterface
     * @throws \LogicException
     */
    public function getValidator(string $type): ValidatorInterface
    {
        switch ($type) {
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

    public function getBooleanValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['BooleanValidator'])) {
            self::$validators['BooleanValidator'] = new Validator\BooleanValidator();
        }

        return self::$validators['BooleanValidator'];
    }

    public function getDateTimeValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['DateTimeValidator'])) {
            self::$validators['DateTimeValidator'] = new Validator\DateTimeValidator();
        }

        return self::$validators['DateTimeValidator'];
    }

    public function getDateValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['DateValidator'])) {
            self::$validators['DateValidator'] = new Validator\DateValidator();
        }

        return self::$validators['DateValidator'];
    }

    public function getTimeValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['TimeValidator'])) {
            self::$validators['TimeValidator'] = new Validator\TimeValidator();
        }

        return self::$validators['TimeValidator'];
    }

    public function getTimestampValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['TimestampValidator'])) {
            self::$validators['TimestampValidator'] = new Validator\TimestampValidator();
        }

        return self::$validators['TimestampValidator'];
    }

    public function getEmailValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['EmailValidator'])) {
            self::$validators['EmailValidator'] = new Validator\EmailValidator();
        }

        return self::$validators['EmailValidator'];
    }

    public function getFloatValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['FloatValidator'])) {
            self::$validators['FloatValidator'] = new Validator\FloatValidator();
        }

        return self::$validators['FloatValidator'];
    }

    public function getIntegerValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['IntegerValidator'])) {
            self::$validators['IntegerValidator'] = new Validator\IntegerValidator();
        }

        return self::$validators['IntegerValidator'];
    }

    public function getNullValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['NullValidator'])) {
            self::$validators['NullValidator'] = new Validator\NullValidator();
        }

        return self::$validators['NullValidator'];
    }

    public function getIpValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['IpValidator'])) {
            self::$validators['IpValidator'] = new Validator\IpValidator();
        }

        return self::$validators['IpValidator'];
    }

    public function getRegexpValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['RegexpValidator'])) {
            self::$validators['RegexpValidator'] = new Validator\RegexpValidator();
        }

        return self::$validators['RegexpValidator'];
    }

    public function getUrlValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['UrlValidator'])) {
            self::$validators['UrlValidator'] = new Validator\UrlValidator();
        }

        return self::$validators['UrlValidator'];
    }

    public function getStringValidator(): ValidatorInterface
    {
        if (!isset(self::$validators['StringValidator'])) {
            self::$validators['StringValidator'] = new Validator\StringValidator();
        }

        return self::$validators['StringValidator'];
    }
}
