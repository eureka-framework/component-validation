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
use Eureka\Component\Validation\Validator\IntegerValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class IntegerValidatorTest
 *
 * @author Romain Cottard
 */
class IntegerValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return new IntegerValidator();
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
     * @return void
     */
    public function testWithOctalValueAsValidValues(): void
    {
        $this->assertSame(octdec('777'), $this->getValidator()->validate(0777, [], FILTER_FLAG_ALLOW_OCTAL));
    }

    /**
     * @return void
     */
    public function testWithHexadecimalValueAsValidValues(): void
    {
        $this->assertSame(hexdec('fa11'), $this->getValidator()->validate('0xfa11', [], FILTER_FLAG_ALLOW_HEX));
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public function validValuesProvider(): array
    {
        return [
            [0.0,  0],
            [0,    0],
            [15, 15],
            ['42', 42],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public function invalidValuesProvider(): array
    {
        return [
            [1.20, 1],
            ['0.0.0', false],
            [null, false],
            ['true', false],
            ['1 000,0', false],
            ['1,000.0', false],
            ['0xfa11', false],
            ['fa11', false],
            ['0777', false],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public function validValuesWithOptionsProvider(): array
    {
        $default = -1;
        $options = ['default' => $default];

        return [
            [0.0, ['default' => $default], 0],
            [15, ['default' => $default, 'min_range' => 0, 'max_range' => 100], 15],
            ['42', ['default' => $default, 'min_range' => 42, 'max_range' => 42], 42],
            [-128,  array_merge($options, IntegerValidator::TINYINT_SIGNED), -128],
            [127,  array_merge($options, IntegerValidator::TINYINT_SIGNED), 127],
            [128,  array_merge($options, IntegerValidator::TINYINT_UNSIGNED), 128],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public function invalidValuesWithOptionsProvider(): array
    {
        $default = -1;
        $options = ['default' => $default];

        return [
            ['0.0.0', $options, $default],
            [null, $options, $default],
            [1.20, ['default' => $default], $default],
            [1.20, ['default' => $default, 'min_range' => 1, 'max_range' => 2], $default],
            [1.01, array_merge($options, ['min_range' => 0, 'max_range' => 1]), $default],
            [254,  array_merge($options, IntegerValidator::TINYINT_SIGNED), $default],
            [256,  array_merge($options, IntegerValidator::TINYINT_UNSIGNED), $default],
        ];
    }
}
