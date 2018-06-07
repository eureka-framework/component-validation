<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Tests;

use Eureka\Component\Validation\Validator\UrlValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class UrlValidatorTest
 *
 * @author Romain Cottard
 */
class UrlValidatorTest extends TestCase
{
    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getValidator()
    {
        return new UrlValidator();
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
     * @return array
     */
    public function validValuesProvider()
    {
        return [
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
            ['https://www.example.com', 'https://www.example.com'],
            ['https://example.com', 'https://example.com'],
        ];
    }

    /**
     * @return array
     */
    public function invalidValuesProvider()
    {
        return [

            ['a', false],
            ['/www.ietf.org/rfc/rfc2396.txt', false],
            [192021692, false],
            ['John.Doe@example.com', false],
            ['tel:+1-816-555-1212', false],
            ['urn:oasis:names:specification:docbook:dtd:xml:4.1.2', false],
            ['http://www.math..uio.no.example.net/faq/compression-faq/part1.html', false],
            ['://www.example.com', false],
            ['www.example.com', false],
            ['example.com', false],
        ];
    }
}
