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
use Eureka\Component\Validation\Validator\StringValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class StringValidatorTest
 *
 * @author Romain Cottard
 */
class StringValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return new StringValidator();
    }

    #[DataProvider('validValuesProvider')]
    public function testWithValidValues(mixed $value, mixed $excepted): void
    {
        self::assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  array<string,string|null|int|float|bool> $options
     */
    #[DataProvider('invalidValuesProvider')]
    public function testWithInvalidValues(mixed $value, array $options): void
    {
        $this->expectException(ValidationException::class);
        $this->getValidator()->validate($value, $options);
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
            ['',  ''],
            ['string', 'string'],
            ['This is a valid string', 'This is a valid string'],
            [' ! €$#!@ :)', ' ! €$#!@ :)'],
            ['42', '42'],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public static function invalidValuesProvider(): array
    {
        return [
            [42, []],
            [null, []],
            [false, []],
            ['a', ['min_length' => 2]],
            ['abcdefghijklmnopqrstuvwxyz', ['min_length' => 1, 'max_length' => 25]],
            ['', ['default' => '', 'min_length' => 1]],
            ['abcdefghijklmnopqrstuvwxyz', ['default' => '', 'min_length' => 1, 'max_length' => 25]],
            ['abcdefghijklmnopqrstuvwxyz', ['default' => '', 'min_length' => 1, 'max_length' => 25]],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public static function validValuesWithOptionsProvider(): array
    {
        $options = ['default' => ''];
        return [
            ['', $options, ''],
            ['string', $options, 'string'],
            ['This is a valid string', $options, 'This is a valid string'],
            [' ! €$#!@ :)', $options, ' ! €$#!@ :)'],
            ['42', $options, '42'],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public static function invalidValuesWithOptionsProvider(): array
    {
        $default = '';
        $options = ['default' => $default];

        return [
            [42, $options, $default],
            [null, $options, $default],
            [false, $options, $default],
        ];
    }
}
