<?php

declare(strict_types=1);

/*
 * This file is part of the Tests package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Unit\Domain\Model\Common\VO;

use Domain\Model\Common\Exception\InvalidPhone;
use Domain\Model\Common\VO\PhoneField;
use PHPUnit\Framework\TestCase;

class PhoneFieldTest extends TestCase
{
    final public function testInstantiatePhoneNumber(): void
    {
        // Arrange & Act
        $phone = PhoneField::fromString('+33179923223');

        // Assert
        static::assertEquals(
            new PhoneField('+33179923223'),
            $phone
        );
    }

    final public function testCreateWithInvalidStringThrowADomainException(): void
    {
        // Arrange
        $this->expectException(InvalidPhone::class);

        // Act & Assert
        PhoneField::fromString('+55$32-55-78-85-62-49-21');
    }
}
