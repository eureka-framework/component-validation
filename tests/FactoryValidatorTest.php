<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation\Tests;

use Eureka\Component\Validation\Validator\BooleanValidator;
use Eureka\Component\Validation\Validator\DateTimeValidator;
use Eureka\Component\Validation\Validator\DateValidator;
use Eureka\Component\Validation\Validator\EmailValidator;
use Eureka\Component\Validation\Validator\FloatValidator;
use Eureka\Component\Validation\Validator\IntegerValidator;
use Eureka\Component\Validation\Validator\IpValidator;
use Eureka\Component\Validation\Validator\NullValidator;
use Eureka\Component\Validation\Validator\RegexpValidator;
use Eureka\Component\Validation\Validator\StringValidator;
use Eureka\Component\Validation\Validator\TimestampValidator;
use Eureka\Component\Validation\Validator\TimeValidator;
use Eureka\Component\Validation\Validator\UrlValidator;
use Eureka\Component\Validation\ValidatorFactory;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class FactoryValidatorTest
 *
 * @author Romain Cottard
 */
class FactoryValidatorTest extends TestCase
{
    /** @var ValidatorFactory $factory */
    private ValidatorFactory $factory;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->factory = new ValidatorFactory();
    }

    /**
     * @param string $type
     * @param class-string<ValidatorInterface> $expectedClass
     * @return void
     *
     * @dataProvider dataProviderFactory
     */
    public function testICanGetValidatorWithFactory(string $type, string $expectedClass): void
    {
        $validator = $this->factory->getValidator($type);
        $this->assertInstanceOf($expectedClass, $validator);
    }

    /**
     * @return void
     */
    public function testIHaveAnExceptionWhenITryToGetValidatorWithInvalidType(): void
    {
        $this->expectException(\LogicException::class);
        $this->factory->getValidator('unknown');
    }

    /**
     * @return string[][]
     */
    public function dataProviderFactory(): array
    {
        return [
            ['boolean', BooleanValidator::class],
            ['datetime', DateTimeValidator::class],
            ['date', DateValidator::class],
            ['time', TimeValidator::class],
            ['timestamp', TimestampValidator::class],
            ['email', EmailValidator::class],
            ['float', FloatValidator::class],
            ['double', FloatValidator::class],
            ['decimal', FloatValidator::class],
            ['integer', IntegerValidator::class],
            ['null', NullValidator::class],
            ['~', NullValidator::class],
            ['', NullValidator::class],
            ['ip', IpValidator::class],
            ['regexp', RegexpValidator::class],
            ['url', UrlValidator::class],
            ['string', StringValidator::class],
        ];
    }
}
