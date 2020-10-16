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
use Eureka\Component\Validation\Validator\BooleanValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class BooleanValidatorTest
 *
 * @author Romain Cottard
 */
class BooleanValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return new BooleanValidator();
    }

    /**
     * @param  mixed $value
     * @param  bool $excepted
     * @return void
     * @dataProvider validTrueValuesProvider
     */
    public function testWithValidTrueValues($value, bool $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  bool $excepted
     * @return void
     * @dataProvider validFalseValuesProvider
     */
    public function testWithValidFalseValues($value, bool $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  bool $excepted
     * @return void
     * @dataProvider invalidBooleanValuesProvider
     */
    public function testWithInvalidBooleanValues($value, bool $excepted)
    {
        $this->expectException(ValidationException::class);
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  bool $excepted
     * @return void
     * @dataProvider invalidBooleanValuesWithOptionsProvider
     */
    public function testWithInvalidBooleanWithDefaultValues($value, array $options, bool $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  bool $excepted
     * @return void
     * @dataProvider invalidBooleanValuesWithOptionsProvider
     */
    public function testWithInvalidBooleanWithDefaultForceNullValues($value, array $options, bool $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options, FILTER_NULL_ON_FAILURE));
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
