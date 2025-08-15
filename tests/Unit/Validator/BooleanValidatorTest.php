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
use Eureka\Component\Validation\Validator\BooleanValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Class BooleanValidatorTest
 *
 * @author Romain Cottard
 */
class BooleanValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return new BooleanValidator();
    }

    #[DataProvider('validTrueValuesProvider')]
    public function testWithValidTrueValues(mixed $value, bool $excepted): void
    {
        self::assertSame($excepted, $this->getValidator()->validate($value));
    }

    #[DataProvider('validFalseValuesProvider')]
    public function testWithValidFalseValues(mixed $value, bool $excepted): void
    {
        self::assertSame($excepted, $this->getValidator()->validate($value));
    }

    #[DataProvider('invalidBooleanValuesProvider')]
    public function testWithInvalidBooleanValuesAnd(mixed $value, bool $excepted): void
    {
        self::assertNull($this->getValidator()->validate($value));
    }

    #[DataProvider('invalidBooleanValuesProvider')]
    public function testWithInvalidBooleanValuesAndValidDefaultValue(mixed $value, bool $excepted): void
    {
        self::assertSame($excepted, $this->getValidator()->validate($value, ['default' => $excepted]));
    }

    public function testWithInvalidBooleanValuesAndInvalidDefaultValue(): void
    {
        $this->expectException(ValidationException::class);
        $this->getValidator()->validate('n', ['default' => 'false']);
    }

    /**
     * @param  array<string,string|null|int|float|bool> $options
     */
    #[DataProvider('invalidBooleanValuesWithOptionsProvider')]
    public function testWithInvalidBooleanWithDefaultValues(mixed $value, array $options, bool $excepted): void
    {
        self::assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @param  array<string,string|null|int|float|bool> $options
     */
    #[DataProvider('invalidBooleanValuesWithOptionsProvider')]
    public function testWithInvalidBooleanWithDefaultForceNullValues(mixed $value, array $options, bool $excepted): void
    {
        self::assertSame($excepted, $this->getValidator()->validate($value, $options, FILTER_NULL_ON_FAILURE));
    }

    /**
     * @return array<int, array<int, string|bool|int|null>>
     */
    public static function validTrueValuesProvider(): array
    {
        return [
            ['yes', true],
            ['1', true],
            ['true', true],
            ['on', true],
            ['ON', true],
            [true, true],
            [1, true],
            ['TRUE', true],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public static function validFalseValuesProvider(): array
    {
        return [
            ['no', false],
            ['0', false],
            ['false', false],
            ['off', false],
            ['OFF', false],
            [false, false],
            [0, false],
            [0.0, false],
            ['', false],
            [null, false],
            ['FALSE', false],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null>>
     */
    public static function invalidBooleanValuesProvider(): array
    {
        return [
            ['non', false],
            ['oui', true],
            ['y', true],
            ['n', false],
            ['o', true],
            [2, false],
            ['null', false],
        ];
    }

    /**
     * @return array<array<string|bool|int|float|null|array<string,string|null|int|float|bool>>>
     */
    public static function invalidBooleanValuesWithOptionsProvider(): array
    {
        return [
            ['non', ['default' => false], false],
            ['oui', ['default' => true], true],
            ['y', ['default' => true], true],
            ['n', ['default' => false], false],
            ['o', ['default' => true], true],
            [2, ['default' => false], false],
            ['null', ['default' => false], false],
        ];
    }
}
