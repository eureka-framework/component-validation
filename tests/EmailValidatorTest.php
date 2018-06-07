<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Tests;

use Eureka\Component\Validation\Validator\EmailValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailValidatorTest
 *
 * @author Romain Cottard
 */
class EmailValidatorTest extends TestCase
{
    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getValidator()
    {
        return new EmailValidator();
    }

    /**
     * @param  mixed $value
     * @param  bool $excepted
     * @return void
     * @dataProvider validValuesProvider
     */
    public function testWithValidValues($value, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  bool $excepted
     * @return void
     * @expectedException \Eureka\Component\Validation\Exception\ValidationException
     * @dataProvider invalidValuesProvider
     */
    public function testWithInvalidValues($value, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  bool $excepted
     * @return void
     * @dataProvider validValuesWithOptionsProvider
     */
    public function testWithValidValueAndDefaultValues($value, $options, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  bool $excepted
     * @return void
     * @dataProvider invalidValuesWithOptionsProvider
     */
    public function testWithInvalidValueAndDefaultValues($value, $options, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @return array
     */
    public function validValuesProvider()
    {
        return [
            ['test@localhost.com',           'test@localhost.com'],
            ['test@localhost.email',         'test@localhost.email'],
            ['test+1@localhost.com',         'test+1@localhost.com'],
            ['test.1@localhost.com',         'test.1@localhost.com'],
            ['test-1@localhost.com',         'test-1@localhost.com'],
            ['test@localhost.co.uk',         'test@localhost.co.uk'],
            ['test@localhost.mylittleponey', 'test@localhost.mylittleponey'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesProvider()
    {
        return [
            ['Test Example <test@example.com>', false],
            ['test@localhost', false],
            ['test..1@localhost', false],
            ['(comment)test@localhost.com',  false],
            ['@localhost.com',  false],
        ];
    }

    /**
     * @return array
     */
    public function validValuesWithOptionsProvider()
    {
        $default = 'test@example.com';
        $options = ['default' => $default];

        return [
            ['test@localhost.com',           $options, 'test@localhost.com'],
            ['test@localhost.email',         $options, 'test@localhost.email'],
            ['test+1@localhost.com',         $options, 'test+1@localhost.com'],
            ['test.1@localhost.com',         $options, 'test.1@localhost.com'],
            ['test-1@localhost.com',         $options, 'test-1@localhost.com'],
            ['test@localhost.co.uk',         $options, 'test@localhost.co.uk'],
            ['test@localhost.mylittleponey', $options, 'test@localhost.mylittleponey'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesWithOptionsProvider()
    {
        $default = null;
        $options = ['default' => $default];

        return [
            ['Test Example <test@example.com>', $options, $default],
            ['test@localhost', $options, $default],
            ['test..1@localhost', $options, $default],
            ['(comment)test@localhost.com', $options, $default],
            ['@localhost.com', $options, $default],
        ];
    }
}
