<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Validation\Tests\Entity;

use Eureka\Component\Validation\Entity\GenericEntity;
use Eureka\Component\Validation\Entity\ValidatorEntityFactory;
use Eureka\Component\Validation\Validator\IntegerValidator;
use Eureka\Component\Validation\ValidatorFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class GenericEntityTest
 *
 * @author Romain Cottard
 */
class GenericEntityTest extends TestCase
{
    /**
     * @return void
     */
    public function testICanInstantiateAValidEntity(): void
    {
        $data = [
            'userId'     => 1,
            'userName'   => 'Romain',
            'user_email' => 'test@example.com',
            'IsEnabled'  => true,
        ];

        $config = [
            'user_id'   => ['type' => 'integer', 'options' => IntegerValidator::INT_UNSIGNED],
            'UserEmail' => ['type' => 'email'],
        ];

        $entity = new GenericEntity(new ValidatorFactory(), $config, $data);

        $this->assertTrue($entity->isValid());
        $this->assertTrue($entity->isEnabled());
        $this->assertSame(1, $entity->getUserId());

        $entity->setUserId(2);
        $this->assertSame(2, $entity->getUserId());
        $this->assertNull($entity->getAny());
    }

    public function testIHaveAnExceptionWhenITryToGetValueWithAnInvalidMethodName(): void
    {
        $entityFactory = new ValidatorEntityFactory(new ValidatorFactory());
        $entity = $entityFactory->createGeneric([], []);

        $this->expectException(\LogicException::class);
        $entity->anyMethod();
    }

    /**
     * @return void
     */
    public function testICanInstantiateAnInvalidEntity(): void
    {
        $data = [
            'userId'     => 1,
            'userName'   => 'Romain',
            'user_email' => 'test@example.com',
        ];

        $config = [
            'userId'   => ['type' => 'string'],
            'UserEmail' => ['type' => 'email'],
        ];

        $entity = new GenericEntity(new ValidatorFactory(), $config, $data);

        $this->assertFalse($entity->isValid());
        $this->assertCount(1, $entity->getErrors());
    }
}
