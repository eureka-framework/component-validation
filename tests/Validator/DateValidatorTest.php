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
use Eureka\Component\Validation\Validator\DateValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class DateValidatorTest
 *
 * @author Romain Cottard
 */
class DateValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return new DateValidator();
    }

    /**
     * @param  mixed $value
     * @param  mixed $excepted
     * @return void
     * @dataProvider validValuesProvider
     */
    public function testWithValidValues($value, $excepted): void
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  mixed $excepted
     * @return void
     * @dataProvider invalidValuesProvider
     */
    public function testWithInvalidValues($value, $excepted): void
    {
        $this->expectException(ValidationException::class);
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  array<string,string|null|int|float|bool> $options
     * @param  mixed $excepted
     * @return void
     * @dataProvider validValuesWithOptionsProvider
     */
    public function testWithValidValueAndDefaultValues($value, array $options, $excepted): void
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @param  mixed $value
     * @param  array<string,string|null|int|float|bool> $options
     * @param  mixed $excepted
     * @return void
     * @dataProvider invalidValuesWithOptionsProvider
     */
    public function testWithInvalidValueAndDefaultValues($value, array $options, $excepted): void
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public function validValuesProvider(): array
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
     * @return array<array<string|bool|int|float|null>>
     */
    public function invalidValuesProvider(): array
    {
        return [
            ['-2018-01-01', false],
            ['01-07-1901',  false],
            ['01-07-1901 12:00',  false],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string>>>
     */
    public function validValuesWithOptionsProvider(): array
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
     * @return array<array<string|bool|int|float|null|array<string,string>>>
     */
    public function invalidValuesWithOptionsProvider(): array
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
