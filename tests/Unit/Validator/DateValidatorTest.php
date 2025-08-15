<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation\Tests\Unit\Validator;

use Eureka\Component\Validation\Exception\ValidationException;
use Eureka\Component\Validation\Validator\DateValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class DateValidatorTest
 *
 * @author Romain Cottard
 */
class DateValidatorTest extends TestCase
{
    public function getValidator(): ValidatorInterface
    {
        return new DateValidator();
    }

    #[DataProvider('validValuesProvider')]
    public function testWithValidValues(mixed $value, mixed $excepted): void
    {
        self::assertSame($excepted, $this->getValidator()->validate($value));
    }

    #[DataProvider('invalidValuesProvider')]
    public function testWithInvalidValues(mixed $value, mixed $excepted): void
    {
        $this->expectException(ValidationException::class);
        self::assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  array<string,string|null|int|float|bool> $options
     */
    #[DataProvider('validValuesWithOptionsProvider')]
    public function testWithValidValueAndDefaultValues(mixed $value, array $options, mixed $excepted): void
    {
        self::assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @param  array<string,string|null|int|float|bool> $options
     */
    #[DataProvider('invalidValuesWithOptionsProvider')]
    public function testWithInvalidValueAndDefaultValues(mixed $value, array $options, mixed $excepted): void
    {
        self::assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public static function validValuesProvider(): array
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
    public static function invalidValuesProvider(): array
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
    public static function validValuesWithOptionsProvider(): array
    {
        $default = '2001-01-01';
        $options = ['format' => 'Y-m-d', 'format_output' => 'Y-m-d', 'default' => $default];

        return [
            ['2018-01-01', $options, '2018-01-01'],
            ['2099-12-31', $options, '2099-12-31'],
            ['1901-07-01', $options, '1901-07-01'],
            ['2020-02-29', $options, '2020-02-29'],
            ['12-31-2099', \array_merge($options, ['format' => 'm-d-Y', 'format_output' => 'd-m-Y']), '31-12-2099'],
            ['99-12-31',   \array_merge($options, ['format' => 'y-m-d']), '1999-12-31'],
            ['01-07-1901', \array_merge($options, ['format' => 'd-m-Y']), '1901-07-01'],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string>>>
     */
    public static function invalidValuesWithOptionsProvider(): array
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
