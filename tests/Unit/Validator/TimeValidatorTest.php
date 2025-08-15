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
use Eureka\Component\Validation\Validator\TimeValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
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
            ['00:00:00', '00:00:00'],
            ['23:59:59', '23:59:59'],
            ['12:00:00', '12:00:00'],
            ['24:00:00', '00:00:00'],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public static function invalidValuesProvider(): array
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
    public static function validValuesWithOptionsProvider(): array
    {
        $default = '00:00:00';
        $options = ['format' => 'H:i:s', 'format_output' => 'H:i:s', 'default' => $default];

        return [
            ['00:00:00', $options, '00:00:00'],
            ['23:59:59', $options, '23:59:59'],
            ['12:00:00', $options, '12:00:00'],
            ['24:00:00', $options, '00:00:00'],
            ['23:59:59', \array_merge($options, ['format_output' => 'H:i']), '23:59'],
            ['23:59',    \array_merge($options, ['format' => 'H:i']), '23:59:00'],
            ['1:00', $options, '00:00:00'],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string>>>
     */
    public static function invalidValuesWithOptionsProvider(): array
    {
        $default = '00:00:00';
        $options = ['format' => 'H:i:s', 'format_output' => 'H:i:s', 'default' => $default];

        return [
            ['-10:00:00', \array_merge($options, ['format' => '-H:i:s']), '10:00:00'],
            ['10:00',     \array_merge($options, ['format' => 'H:i']), '10:00:00'],
            ['1:00',      \array_merge($options, ['format' => 'h:i']), '01:00:00'],
        ];
    }
}
