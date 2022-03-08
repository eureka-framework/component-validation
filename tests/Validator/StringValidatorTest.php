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
use Eureka\Component\Validation\Validator\StringValidator;
use Eureka\Component\Validation\ValidatorInterface;
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
     * @param  array<string,string|null|int|float|bool> $options
     * @return void
     * @dataProvider invalidValuesProvider
     */
    public function testWithInvalidValues($value, array $options): void
    {
        $this->expectException(ValidationException::class);
        $this->getValidator()->validate($value, $options);
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
            ['',  ''],
            ['string', 'string'],
            ['This is a valid string', 'This is a valid string'],
            [' ! €$#!@ :)', ' ! €$#!@ :)'],
            ['42', '42']
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public function invalidValuesProvider(): array
    {
        return [
            [42, []],
            [null, []],
            [false, []],
            ['a', ['min_length' => 2]],
            ['abcdefghijklmnopqrstuvwxyz', ['min_length' => 1, 'max_length' => 25]],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public function validValuesWithOptionsProvider(): array
    {
        $options = ['default' => ''];
        return [
            ['', $options, ''],
            ['string', $options, 'string'],
            ['This is a valid string', $options, 'This is a valid string'],
            [' ! €$#!@ :)', $options, ' ! €$#!@ :)'],
            ['42', $options, '42']
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public function invalidValuesWithOptionsProvider(): array
    {
        $default = '';
        $options = ['default' => $default];

        return [
            [42, $options, $default],
            [null, $options, $default],
            [false, $options, $default],
            ['', array_merge($options, ['min_length' => 1]), $default],
            ['abcdefghijklmnopqrstuvwxyz', array_merge($options, ['max_length' => 25]), $default],
            ['abcdefghijklmnopqrstuvwxyz', array_merge($options, ['min_length' => 1, 'max_length' => 25]), $default],
        ];
    }
}
