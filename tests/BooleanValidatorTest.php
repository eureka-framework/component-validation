<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Tests;

use Eureka\Component\Validation\Validator\BooleanValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class BooleanValidatorTest
 *
 * @author Romain Cottard
 */
class BooleanValidatorTest extends TestCase
{
    /**
     * @param  mixed $value
     * @param  bool $excepted
     * @return void
     * @dataProvider validTrueValuesProvider
     */
    public function testWithValidTrueValues($value, $excepted)
    {
        $this->assertSame($excepted, (new BooleanValidator())->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  bool $excepted
     * @return void
     * @dataProvider validFalseValuesProvider
     */
    public function testWithValidFalseValues($value, $excepted)
    {
        $this->assertSame($excepted, (new BooleanValidator())->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  bool $excepted
     * @return void
     * @expectedException \Eureka\Component\Validation\Exception\ValidationException
     * @dataProvider invalidBooleanValuesProvider
     */
    public function testWithInvalidBooleanValues($value, $excepted)
    {
        $this->assertSame($excepted, (new BooleanValidator())->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  bool $excepted
     * @return void
     * @dataProvider invalidBooleanValuesWithOptionsProvider
     */
    public function testWithInvalidBooleanWithDefaultValues($value, $options, $excepted)
    {
        $this->assertSame($excepted, (new BooleanValidator())->validate($value, $options));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  bool $excepted
     * @return void
     * @dataProvider invalidBooleanValuesWithOptionsProvider
     */
    public function testWithInvalidBooleanWithDefaultForceNullValues($value, $options, $excepted)
    {
        $this->assertSame($excepted, (new BooleanValidator())->validate($value, $options, FILTER_NULL_ON_FAILURE));
    }

    /**
     * @return array
     */
    public function validTrueValuesProvider()
    {
        return [
            ['yes', true],
            ['1', true],
            ['true', true],
            ['on', true],
            ['ON', true],
            [true, true],
            [1, true],
            ['TRUE', true],
        ];
    }

    /**
     * @return array
     */
    public function validFalseValuesProvider()
    {
        return [
            ['no', false],
            ['0', false],
            ['false', false],
            ['off', false],
            ['OFF', false],
            [false, false],
            [0, false],
            [0.0, false],
            ['', false],
            [null, false],
            ['FALSE', false],
        ];
    }

    /**
     * @return array
     */
    public function invalidBooleanValuesProvider()
    {
        return [
            ['non', false],
            ['oui', true],
            ['y', true],
            ['n', false],
            ['o', true],
            [2, false],
            ['null', false],
        ];
    }

    /**
     * @return array
     */
    public function invalidBooleanValuesWithOptionsProvider()
    {
        return [
            ['non', ['default' => false], false],
            ['oui', ['default' => true], true],
            ['y', ['default' => true], true],
            ['n', ['default' => false], false],
            ['o', ['default' => true], true],
            [2, ['default' => false], false],
            ['null', ['default' => false], false],
        ];
    }
}
