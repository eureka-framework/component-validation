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
    public function getValidator(): ValidatorInterface
    {
        return new RegexpValidator();
    }

    /**
     * @return void
     */
    public function testWithValidValue(): void
    {
        $text = 'The test passed!';
        self::assertSame($text, $this->getValidator()->validate($text, ['regexp' => '`(.*)passed!`']));
    }

    /**
     * @return void
     */
    public function testWithEmptyStringValue(): void
    {
        $text = 'The test failed!';
        $this->expectException(ValidationException::class);
        self::assertSame($text, $this->getValidator()->validate($text, ['regexp' => '`(.+)passed(.*)`']));
    }
}
