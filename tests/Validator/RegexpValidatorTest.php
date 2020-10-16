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
use Eureka\Component\Validation\Validator\RegexpValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class RegexpValidatorTest
 *
 * @author Romain Cottard
 */
class RegexpValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return new RegexpValidator();
    }

    /**
     * @return void
     */
    public function testWithValidValue()
    {
        $text = 'The test passed!';
        $this->assertSame($text, $this->getValidator()->validate($text, ['regexp' => '`(.*)passed!`']));
    }

    /**
     * @return void
     */
    public function testWithEmptyStringValue()
    {
        $text = 'The test failed!';
        $this->expectException(ValidationException::class);
        $this->assertSame($text, $this->getValidator()->validate($text, ['regexp' => '`(.+)passed(.*)`']));
    }
}
