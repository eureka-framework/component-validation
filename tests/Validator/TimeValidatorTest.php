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
use Eureka\Component\Validation\Validator\TimeValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class TimeValidatorTest
 *
 * @author Romain Cottard
 */
class TimeValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return new TimeValidator();
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
            ['00:00:00', '00:00:00'],
            ['23:59:59', '23:59:59'],
            ['12:00:00', '12:00:00'],
            ['24:00:00', '00:00:00'],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public function invalidValuesProvider(): array
    {
        return [
            ['-00:00:00', false],
            ['00:00',  false],
            ['1:00',  false],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string>>>
     */
    public function validValuesWithOptionsProvider(): array
    {
        $default = '00:00:00';
        $options = ['format' => 'H:i:s', 'format_output' => 'H:i:s', 'default' => $default];

        return [
            ['00:00:00', $options, '00:00:00'],
            ['23:59:59', $options, '23:59:59'],
            ['12:00:00', $options, '12:00:00'],
            ['24:00:00', $options, '00:00:00'],
            ['23:59:59', array_merge($options, ['format_output' => 'H:i']), '23:59'],
            ['23:59',    array_merge($options, ['format' => 'H:i']), '23:59:00'],
            ['1:00', $options, '00:00:00'],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string>>>
     */
    public function invalidValuesWithOptionsProvider(): array
    {
        $default = '00:00:00';
        $options = ['format' => 'H:i:s', 'format_output' => 'H:i:s', 'default' => $default];

        return [
            ['-10:00:00', array_merge($options, ['format' => '-H:i:s']), '10:00:00'],
            ['10:00',     array_merge($options, ['format' => 'H:i']), '10:00:00'],
            ['1:00',      array_merge($options, ['format' => 'h:i']), '01:00:00'],
        ];
    }
}
