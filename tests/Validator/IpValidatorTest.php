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
use Eureka\Component\Validation\Validator\IpValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class IpValidatorTest
 *
 * @author Romain Cottard
 */
class IpValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return new IpValidator();
    }

    /**
     * @param  mixed $value
     * @param  mixed $excepted
     * @return void
     * @dataProvider validValuesProvider
     */
    public function testWithValidValues($value, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  mixed $excepted
     * @return void
     * @dataProvider invalidValuesProvider
     */
    public function testWithInvalidValues($value, $excepted)
    {
        $this->expectException(ValidationException::class);
        $this->assertSame($excepted, $this->getValidator()->validate($value));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  mixed $excepted
     * @return void
     * @dataProvider validValuesWithOptionsProvider
     */
    public function testWithValidValueAndDefaultValues($value, array $options, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @param  mixed $value
     * @param  array $options
     * @param  mixed $excepted
     * @return void
     * @dataProvider invalidValuesWithOptionsProvider
     */
    public function testWithInvalidValueAndDefaultValues($value, array $options, $excepted)
    {
        $this->assertSame($excepted, $this->getValidator()->validate($value, $options));
    }

    /**
     * @return void
     */
    public function testIpNotInReservedNorPrivateRangesWithPublicIp()
    {
        $this->assertSame('193.1.2.3', $this->getValidator()->validate('193.1.2.3', [], FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE));
    }

    /**
     * @return void
     */
    public function testIpNotInReservedRangeWithReservedIp()
    {
        $this->expectException(ValidationException::class);
        $this->assertSame('240.0.0.1', $this->getValidator()->validate('240.0.0.1', [], FILTER_FLAG_NO_RES_RANGE));
    }

    /**
     * @return void
     */
    public function testIpNotInPrivateRangeWithPrivateIp()
    {
        $this->expectException(ValidationException::class);
        $this->assertSame('172.16.0.1', $this->getValidator()->validate('172.16.0.1', [], FILTER_FLAG_NO_PRIV_RANGE));
    }

    /**
     * @return void
     */
    public function testIpV6WithValidValue()
    {
        $this->assertSame('2001:0db8:0000:85a3:0000:0000:ac1f:8001', $this->getValidator()->validate('2001:0db8:0000:85a3:0000:0000:ac1f:8001', [], FILTER_FLAG_IPV6));
        $this->assertSame('2001:db8:0:85a3:0:0:ac1f:8001', $this->getValidator()->validate('2001:db8:0:85a3:0:0:ac1f:8001', [], FILTER_FLAG_IPV6));
    }

    /**
     * @return void
     */
    public function testIpV6WithInvalidValue()
    {
        $this->expectException(ValidationException::class);
        $this->assertSame('test:0db8:0000:85a3:0000:0000:ac1f:8001', $this->getValidator()->validate('test:0db8:0000:85a3:0000:0000:ac1f:8001', [], FILTER_FLAG_IPV4));
    }

    /**
     * @return array
     */
    public function validValuesProvider()
    {
        return [
            ['192.168.0.1',     '192.168.0.1'],
            ['9.9.9.9',         '9.9.9.9'],
            ['255.255.255.255', '255.255.255.255'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesProvider()
    {
        return [
            ['192.168.0.256',   false],
            ['fe80::291a:1af6:d518:1fc7%17', false],
        ];
    }

    /**
     * @return array
     */
    public function validValuesWithOptionsProvider()
    {
        return [
            ['192.168.0.1',     ['default' => null], '192.168.0.1'],
            ['9.9.9.9',         ['default' => null], '9.9.9.9'],
            ['255.255.255.255', ['default' => null], '255.255.255.255'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesWithOptionsProvider()
    {
        return [
            ['192.168.0.256', ['default' => null], null],
            ['fe80::291a:1af6:d518:1fc7%17', ['default' => null], null],
        ];
    }
}
