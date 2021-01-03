<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Unit\Tests\Core\Domain\Common\Model\VO;

use Core\Domain\Common\Model\Exception\InvalidPhone;
use Core\Domain\Common\Model\VO\PhoneField;
use PHPUnit\Framework\TestCase;

class PhoneFieldTest extends TestCase
{
    final public function testInstantiatePhoneNumber(): void
    {
        // Arrange & Act
        $phone = PhoneField::fromString('+33179923223');

        // Assert
        self::assertEquals(
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
