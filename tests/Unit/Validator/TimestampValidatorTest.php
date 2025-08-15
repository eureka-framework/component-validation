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
use Eureka\Component\Validation\Validator\TimestampValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class TimestampValidatorTest
 *
 * @author Romain Cottard
 */
class TimestampValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return new TimestampValidator();
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

    public function testWithOctalValueAsValidValues(): void
    {
        self::assertSame(octdec('777'), $this->getValidator()->validate(0777, [], FILTER_FLAG_ALLOW_OCTAL));
    }

    public function testWithHexadecimalValueAsValidValues(): void
    {
        self::assertSame(hexdec('fa11'), $this->getValidator()->validate('0xfa11', [], FILTER_FLAG_ALLOW_HEX));
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public static function validValuesProvider(): array
    {
        return [
            [0.0,  0],
            [0,  0],
            [183838884,  183838884],
            [2147483647, 2147483647],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public static function invalidValuesProvider(): array
    {
        return [
            [-1,  false],
            [1.1,  false],
            [2147483648, false],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public static function validValuesWithOptionsProvider(): array
    {
        $default = -1;
        $options = ['default' => $default];

        return [
            [0, $options, 0],
            [183838884, $options,  183838884],
            [2147483647, $options, 2147483647],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public static function invalidValuesWithOptionsProvider(): array
    {
        $default = 0;
        $options = ['default' => $default];

        return [
            [-1, $options, $default],
            [2147483648, $options, $default],
        ];
    }
}
