<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation\Tests\Validator;

use Eureka\Component\Validation\Exception\ValidationException;
use Eureka\Component\Validation\Validator\IntegerValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class IntegerValidatorTest
 *
 * @author Romain Cottard
 */
class IntegerValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return new IntegerValidator();
    }

    /**
     * @param  mixed $value
     * @param  mixed $excepted
     * @return void
     * @dataProvider validValuesProvider
     */
    public function testWithValidValues($value, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  mixed $excepted
     * @return void
     * @dataProvider invalidValuesProvider
     */
    public function testWithInvalidValues($value, $excepted)
    {
        $this->expectException(ValidationException::class);
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  mixed $excepted
     * @return void
     * @dataProvider validValuesWithOptionsProvider
     */
    public function testWithValidValueAndDefaultValues($value, array $options, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  mixed $excepted
     * @return void
     * @dataProvider invalidValuesWithOptionsProvider
     */
    public function testWithInvalidValueAndDefaultValues($value, array $options, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @return void
     */
    public function testWithOctalValueAsValidValues()
    {
        $this->assertSame(octdec(777), $this->getValidator()->validate(0777, [], FILTER_FLAG_ALLOW_OCTAL));
    }

    /**
     * @return void
     */
    public function testWithHexaValueAsValidValues()
    {
        $this->assertSame(hexdec('fa11'), $this->getValidator()->validate('0xfa11', [], FILTER_FLAG_ALLOW_HEX));
    }

    /**
     * @return array
     */
    public function validValuesProvider()
    {
        return [
            [0.0,  0],
            [0,    0],
            [15, 15],
            ['42', 42],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesProvider()
    {
        return [
            [1.20, 1],
            ['0.0.0', false],
            [null, false],
            ['true', false],
            ['1 000,0', false],
            ['1,000.0', false],
            ['0xfa11', false],
            ['fa11', false],
            ['0777', false],
        ];
    }

    /**
     * @return array
     */
    public function validValuesWithOptionsProvider()
    {
        $default = -1;
        $options = ['default' => $default];

        return [
            [0.0, ['default' => $default], 0],
            [15, ['default' => $default, 'min_range' => 0, 'max_range' => 100], 15],
            ['42', ['default' => $default, 'min_range' => 42, 'max_range' => 42], 42],
            [-128,  array_merge($options, IntegerValidator::TINYINT_SIGNED), -128],
            [127,  array_merge($options, IntegerValidator::TINYINT_SIGNED), 127],
            [128,  array_merge($options, IntegerValidator::TINYINT_UNSIGNED), 128],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesWithOptionsProvider()
    {
        $default = -1;
        $options = ['default' => $default];

        return [
            ['0.0.0', $options, $default],
            [null, $options, $default],
            [1.20, ['default' => $default], $default],
            [1.20, ['default' => $default, 'min_range' => 1, 'max_range' => 2], $default],
            [1.01, array_merge($options, ['min_range' => 0, 'max_range' => 1]), $default],
            [254,  array_merge($options, IntegerValidator::TINYINT_SIGNED), $default],
            [256,  array_merge($options, IntegerValidator::TINYINT_UNSIGNED), $default],
        ];
    }
}
