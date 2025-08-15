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
use Eureka\Component\Validation\Validator\NullValidator;
use Eureka\Component\Validation\ValidatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class NullValidatorTest
 *
 * @author Romain Cottard
 */
class NullValidatorTest extends TestCase
{
    /**
     * @return ValidatorInterface
     */
    public function getValidator(): ValidatorInterface
    {
        return new NullValidator();
    }

    /**
     * @return void
     */
    public function testWithNullValue(): void
    {
        self::assertNull($this->getValidator()->validate(null));
    }

    /**
     * @return void
     */
    public function testWithEmptyStringValue(): void
    {
        $this->expectException(ValidationException::class);
        self::assertNull($this->getValidator()->validate(''));
    }
}
