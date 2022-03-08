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
use Eureka\Component\Validation\Validator\TimestampValidator;
use Eureka\Component\Validation\ValidatorInterface;
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
            [0,  0],
            [183838884,  183838884],
            [2147483647, 2147483647],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public function invalidValuesProvider(): array
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
    public function validValuesWithOptionsProvider(): array
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
    public function invalidValuesWithOptionsProvider(): array
    {
        $default = 0;
        $options = ['default' => $default];

        return [
            [-1, $options, $default],
            [2147483648, $options, $default],
        ];
    }
}
