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
use Eureka\Component\Validation\Validator\DomainValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class DomainValidatorTest
 *
 * @author Romain Cottard
 */
class DomainValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return new DomainValidator();
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
     * @return array
     */
    public function validValuesProvider()
    {
        return [
            //~ Normal & complex cases
            ['http://www.math.uio.no.example.net/faq/compression-faq/part1.html', 'http://www.math.uio.no.example.net/faq/compression-faq/part1.html'],
            ['http://www.ietf.org/rfc/rfc2396.txt', 'http://www.ietf.org/rfc/rfc2396.txt'],
            ['ftp://ftp.is.co.za.example.org/rfc/rfc1808.txt', 'ftp://ftp.is.co.za.example.org/rfc/rfc1808.txt'],
            ['gopher://spinaltap.micro.umn.example.edu/00/Weather/California/Los%20Angeles', 'gopher://spinaltap.micro.umn.example.edu/00/Weather/California/Los%20Angeles'],
            ['telnet://melvyl.ucop.example.edu/', 'telnet://melvyl.ucop.example.edu/'],
            ['telnet://192.0.2.16:80/', 'telnet://192.0.2.16:80/'],
            ['ldap://[2001:db8::7]/c=GB?objectClass?one', 'ldap://[2001:db8::7]/c=GB?objectClass?one'],
            ['mailto:mduerst@ifi.unizh.example.gov', 'mailto:mduerst@ifi.unizh.example.gov'],
            ['mailto:John.Doe@example.com', 'mailto:John.Doe@example.com'],
            ['news:comp.infosystems.www.servers.unix', 'news:comp.infosystems.www.servers.unix'],
            ['tel:+1-816-555-1212', 'tel:+1-816-555-1212'],
            ['urn:oasis:names:specification:docbook:dtd:xml:4.1.2', 'urn:oasis:names:specification:docbook:dtd:xml:4.1.2'],

            //~ Weird cases :(
            ['a', 'a'],
            ['/www.ietf.org/rfc/rfc2396.txt', '/www.ietf.org/rfc/rfc2396.txt'],
            [192021692, '192021692'],
            ['John.Doe@example.com', 'John.Doe@example.com'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesProvider()
    {
        return [
            ['http://www.math..uio.no.example.net/faq/compression-faq/part1.html', false],
        ];
    }

    /**
     * @return array
     */
    public function validValuesWithOptionsProvider()
    {
        return [
            //~ Normal & complex cases
            ['http://www.math.uio.no.example.net/faq/compression-faq/part1.html', ['default' => 'http://www.example.com'], 'http://www.math.uio.no.example.net/faq/compression-faq/part1.html'],
            ['http://www.ietf.org/rfc/rfc2396.txt', ['default' => 'http://www.example.com'], 'http://www.ietf.org/rfc/rfc2396.txt'],
            ['ftp://ftp.is.co.za.example.org/rfc/rfc1808.txt', ['default' => 'http://www.example.com'], 'ftp://ftp.is.co.za.example.org/rfc/rfc1808.txt'],
            ['gopher://spinaltap.micro.umn.example.edu/00/Weather/California/Los%20Angeles', ['default' => 'http://www.example.com'], 'gopher://spinaltap.micro.umn.example.edu/00/Weather/California/Los%20Angeles'],
            ['telnet://melvyl.ucop.example.edu/', ['default' => 'http://www.example.com'], 'telnet://melvyl.ucop.example.edu/'],
            ['telnet://192.0.2.16:80/', ['default' => 'http://www.example.com'], 'telnet://192.0.2.16:80/'],
            ['ldap://[2001:db8::7]/c=GB?objectClass?one', ['default' => 'http://www.example.com'], 'ldap://[2001:db8::7]/c=GB?objectClass?one'],
            ['mailto:mduerst@ifi.unizh.example.gov', ['default' => 'http://www.example.com'], 'mailto:mduerst@ifi.unizh.example.gov'],
            ['mailto:John.Doe@example.com', ['default' => 'http://www.example.com'], 'mailto:John.Doe@example.com'],
            ['news:comp.infosystems.www.servers.unix', ['default' => 'http://www.example.com'], 'news:comp.infosystems.www.servers.unix'],

            //~ Weird cases :(
            ['a', ['default' => 'http://www.example.com'], 'a'],
            ['/www.ietf.org/rfc/rfc2396.txt', ['default' => 'http://www.example.com'], '/www.ietf.org/rfc/rfc2396.txt'],
            [192021692, ['default' => 'http://www.example.com'], '192021692'],
            ['John.Doe@example.com', ['default' => 'http://www.example.com'], 'John.Doe@example.com'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesWithOptionsProvider()
    {
        return [
            ['http://www.math..uio.no.example.net/faq/compression-faq/part1.html', ['default' => null], null],
        ];
    }
}
