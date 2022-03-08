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
use Eureka\Component\Validation\Validator\DateTimeValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class DateTimeValidatorTest
 *
 * @author Romain Cottard
 */
class DateTimeValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return new DateTimeValidator();
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
            ['2018-01-01 00:00:00', '2018-01-01 00:00:00'],
            ['2099-12-31 23:59:59', '2099-12-31 23:59:59'],
            ['1901-07-01 12:00:00', '1901-07-01 12:00:00'],
            ['2020-02-29 00:00:00', '2020-02-29 00:00:00'],
            ['2019-02-29 00:00:00', '2019-03-01 00:00:00'],
            ['9-12-31 00:00:00',    '0009-12-31 00:00:00'],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public function invalidValuesProvider(): array
    {
        return [
            ['-2018-01-01 00:00:00', false],
            ['01-07-1901 00:00:00',  false],
            ['01-07-1901 12:00',  false],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string>>>
     */
    public function validValuesWithOptionsProvider(): array
    {
        $default = '2001-01-01';
        $options = ['format' => 'Y-m-d H:i:s', 'format_output' => 'Y-m-d H:i:s', 'default' => $default];

        return [
            ['2018-01-01 00:00:00', $options, '2018-01-01 00:00:00'],
            ['2099-12-31 23:59:59', $options, '2099-12-31 23:59:59'],
            ['1901-07-01 12:00:00', $options, '1901-07-01 12:00:00'],
            ['2020-02-29 00:00:00', $options, '2020-02-29 00:00:00'],
            ['12-31-2099 00:00:00', array_merge($options, ['format' => 'm-d-Y H:i:s', 'format_output' => 'd-m-Y H:i:s']), '31-12-2099 00:00:00'],
            ['99-12-31 00:00:00',   array_merge($options, ['format' => 'y-m-d H:i:s']), '1999-12-31 00:00:00'],
            ['01-07-1901 13:13',    array_merge($options, ['format' => 'd-m-Y H:i']), '1901-07-01 13:13:00'],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string>>>
     */
    public function invalidValuesWithOptionsProvider(): array
    {
        $default = '2001-01-01 12:13:14';
        $options = ['format' => 'Y-m-d H:i:s', 'format_output' => 'Y-m-d H:i:s', 'default' => $default];

        return [
            ['-2018-01-01',      $options, $default],
            ['01-07-1901',       $options, $default],
            ['01-07-1901 12:00', $options, $default],
        ];
    }
}
