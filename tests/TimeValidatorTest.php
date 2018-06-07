<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Tests;

use Eureka\Component\Validation\Validator\TimeValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class TimeValidatorTest
 *
 * @author Romain Cottard
 */
class TimeValidatorTest extends TestCase
{
    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getValidator()
    {
        return new TimeValidator();
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
            ['00:00:00', '00:00:00'],
            ['23:59:59', '23:59:59'],
            ['12:00:00', '12:00:00'],
            ['24:00:00', '00:00:00'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesProvider()
    {
        return [
            ['-00:00:00', false],
            ['00:00',  false],
            ['1:00',  false],
        ];
    }

    /**
     * @return array
     */
    public function validValuesWithOptionsProvider()
    {
        $default = '00:00:00';
        $options = ['format' => 'H:i:s', 'format_output' => 'H:i:s', 'default' => $default];

        return [
            ['00:00:00', $options, '00:00:00'],
            ['23:59:59', $options, '23:59:59'],
            ['12:00:00', $options, '12:00:00'],
            ['24:00:00', $options, '00:00:00'],
            ['23:59:59', array_merge($options, ['format_output' => 'H:i']), '23:59'],
            ['23:59',    array_merge($options, ['format' => 'H:i']), '23:59:00'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesWithOptionsProvider()
    {
        $default = '00:00:00';
        $options = ['format' => 'H:i:s', 'format_output' => 'H:i:s', 'default' => $default];

        return [
            ['-10:00:00', array_merge($options, ['format' => '-H:i:s']), '10:00:00'],
            ['10:00',     array_merge($options, ['format' => 'H:i']), '10:00:00'],
            ['1:00',      array_merge($options, ['format' => 'h:i']), '01:00:00'],
        ];
    }
}
