<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Tests;

use Eureka\Component\Validation\Validator\DateValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class DateValidatorTest
 *
 * @author Romain Cottard
 */
class DateValidatorTest extends TestCase
{
    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getValidator()
    {
        return new DateValidator();
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
     * @return array
     */
    public function validValuesProvider()
    {
        return [
            ['2018-01-01', '2018-01-01'],
            ['2099-12-31', '2099-12-31'],
            ['1901-07-01', '1901-07-01'],
            ['2020-02-29', '2020-02-29'],
            ['2019-02-29', '2019-03-01'],
            ['9-12-31',    '0009-12-31'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesProvider()
    {
        return [
            ['-2018-01-01', false],
            ['01-07-1901',  false],
            ['01-07-1901 12:00',  false],
        ];
    }

    /**
     * @return array
     */
    public function validValuesWithOptionsProvider()
    {
        $default = '2001-01-01';
        $options = ['format' => 'Y-m-d', 'format_output' => 'Y-m-d', 'default' => $default];

        return [
            ['2018-01-01', $options, '2018-01-01'],
            ['2099-12-31', $options, '2099-12-31'],
            ['1901-07-01', $options, '1901-07-01'],
            ['2020-02-29', $options, '2020-02-29'],
            ['12-31-2099', array_merge($options, ['format' => 'm-d-Y', 'format_output' => 'd-m-Y']), '31-12-2099'],
            ['99-12-31',   array_merge($options, ['format' => 'y-m-d']), '1999-12-31'],
            ['01-07-1901', array_merge($options, ['format' => 'd-m-Y']), '1901-07-01'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesWithOptionsProvider()
    {
        $default = '2001-01-01';
        $options = ['format' => 'Y-m-d', 'format_output' => 'Y-m-d', 'default' => $default];

        return [
            ['-2018-01-01',      $options, $default],
            ['01-07-1901',       $options, $default],
            ['01-07-1901 12:00', $options, $default],
        ];
    }
}
