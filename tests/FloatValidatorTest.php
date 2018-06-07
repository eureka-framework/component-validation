<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Tests;

use Eureka\Component\Validation\Validator\FloatValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class FloatValidatorTest
 *
 * @author Romain Cottard
 */
class FloatValidatorTest extends TestCase
{
    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getValidator()
    {
        return new FloatValidator();
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
    public function testWithValidValuesWithThousandSeparator()
    {
        $this->assertSame(1000.01, $this->getValidator()->validate('1,000.01', [], FILTER_FLAG_ALLOW_THOUSAND));
    }

    /**
     * @return array
     */
    public function validValuesProvider()
    {
        return [
            [0.0,  0.0],
            [1.20, 1.20],
            [0,    0.0],
            [0.9999999999999999999999, 0.9999999999999999999999],
            ['0.0', 0.0],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesProvider()
    {
        return [
            ['0.0.0', false],
            [null, false],
            ['true', false],
            ['1 000,0', false],
            ['1,000.0', false],
        ];
    }

    /**
     * @return array
     */
    public function validValuesWithOptionsProvider()
    {
        $default = -1.0;
        $options = ['default' => $default];

        return [
            [0.0, $options, 0.0],
            [1.20, $options, 1.20],
            [0, $options, 0.0],
            ['0,9999999999', array_merge($options, ['decimal' => ',']), 0.9999999999],
            ['0.0', $options, 0.0],
            ['0,9911111111', array_merge($options, ['decimal' => ',']), 0.9911111111],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesWithOptionsProvider()
    {
        $default = 0.0;
        $options = ['default' => $default];

        return [
            ['0.0.0', $options, $default],
            [null, $options, $default],
            ['true', $options, $default],
            ['1 000,0', $options, $default],
            ['1,000.0', $options, $default],
        ];
    }
}
