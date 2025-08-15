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
use Eureka\Component\Validation\Validator\FloatValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class FloatValidatorTest
 *
 * @author Romain Cottard
 */
class FloatValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return new FloatValidator();
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
     * @return void
     */
    public function testWithValidValuesWithThousandSeparator(): void
    {
        self::assertSame(1000.01, $this->getValidator()->validate('1,000.01', [], FILTER_FLAG_ALLOW_THOUSAND));
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public static function validValuesProvider(): array
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
     * @return array<array<string|bool|int|float|null>>
     */
    public static function invalidValuesProvider(): array
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
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public static function validValuesWithOptionsProvider(): array
    {
        $default = -1.0;
        $options = ['default' => $default];

        return [
            [0.0, $options, 0.0],
            [1.20, $options, 1.20],
            [0, $options, 0.0],
            ['0,9999999999', \array_merge($options, ['decimal' => ',']), 0.9999999999],
            ['0.0', $options, 0.0],
            ['0,9911111111', \array_merge($options, ['decimal' => ',']), 0.9911111111],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public static function invalidValuesWithOptionsProvider(): array
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
