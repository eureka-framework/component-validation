<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Validation\Tests;

use Eureka\Component\Validation\Validator\NullValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class IpValidatorTest
 *
 * @author Romain Cottard
 */
class NullValidatorTest extends TestCase
{
    /**
     * @return \Eureka\Component\Validation\ValidatorInterface
     */
    public function getValidator()
    {
        return new NullValidator();
    }

    /**
     * @return void
     */
    public function testWithNullValue()
    {
        $this->assertSame(null, $this->getValidator()->validate(null));
    }

    /**
     * @expectedException \Eureka\Component\Validation\Exception\ValidationException
     */
    public function testWithEmptyStringValue()
    {
        $this->assertSame(null, $this->getValidator()->validate(''));
    }
}
