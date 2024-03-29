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
use Eureka\Component\Validation\Validator\FloatValidator;
use Eureka\Component\Validation\ValidatorInterface;
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
    public function testWithValidValuesWithThousandSeparator(): void
    {
        $this->assertSame(1000.01, $this->getValidator()->validate('1,000.01', [], FILTER_FLAG_ALLOW_THOUSAND));
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public function validValuesProvider(): array
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
    public function invalidValuesProvider(): array
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
    public function validValuesWithOptionsProvider(): array
    {
        $default = -1.0;
        $options = ['default' => $default];

        return [
            [0.0, $options, 0.0],
            [1.20, $options, 1.20],
            [0, $options, 0.0],
            ['0,9999999999', array_merge($options, ['decimal' => ',']), 0.9999999999],
            ['0.0', $options, 0.0],
            ['0,9911111111', array_merge($options, ['decimal' => ',']), 0.9911111111],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public function invalidValuesWithOptionsProvider(): array
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
