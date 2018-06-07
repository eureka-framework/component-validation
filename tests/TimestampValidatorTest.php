<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Tests;

use Eureka\Component\Validation\Validator\TimestampValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class TimestampValidatorTest
 *
 * @author Romain Cottard
 */
class TimestampValidatorTest extends TestCase
{
    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getValidator()
    {
        return new TimestampValidator();
    }

    /**
     * @param  mixed $value
     * @param  bool $excepted
     * @return void
     * @dataProvider validValuesProvider
     */
    public function testWithValidValues($value, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  bool $excepted
     * @return void
     * @expectedException \Eureka\Component\Validation\Exception\ValidationException
     * @dataProvider invalidValuesProvider
     */
    public function testWithInvalidValues($value, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  bool $excepted
     * @return void
     * @dataProvider validValuesWithOptionsProvider
     */
    public function testWithValidValueAndDefaultValues($value, $options, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  bool $excepted
     * @return void
     * @dataProvider invalidValuesWithOptionsProvider
     */
    public function testWithInvalidValueAndDefaultValues($value, $options, $excepted)
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
            [0,  0],
            [183838884,  183838884],
            [2147483647, 2147483647],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesProvider()
    {
        return [
            [-1,  false],
            [1.1,  false],
            [2147483648, false],
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
            [0, $options, 0],
            [183838884, $options,  183838884],
            [2147483647, $options, 2147483647],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesWithOptionsProvider()
    {
        $default = 0;
        $options = ['default' => $default];

        return [
            [-1, $options, $default],
            [2147483648, $options, $default],
        ];
    }
}
