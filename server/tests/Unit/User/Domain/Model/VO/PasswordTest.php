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

namespace Unit\Tests\User\Domain\Model\VO;

use PHPUnit\Framework\TestCase;
use User\Domain\Exception\PasswordMustHaveDigitException;
use User\Domain\Exception\PasswordMustHaveSpecialCharactersException;
use User\Domain\Exception\PasswordMustHaveUpperException;
use User\Domain\Exception\PasswordMustReach8CharactersException;
use User\Domain\Model\VO\Password;

class PasswordTest extends TestCase
{
    final public function testCreateWithLessLongThrowADomainException(): void
    {
        // Arrange
        $this->expectException(PasswordMustReach8CharactersException::class);

        // Act, Assert
        Password::fromString('zaer');
    }

    final public function testCreateWithNoUpperThrowADomainException(): void
    {
        // Arrange
        $this->expectException(PasswordMustHaveUpperException::class);

        // Act, Assert
        Password::fromString('zaerty5rt');
    }

    final public function testCreateWithNoDigitThrowADomainException(): void
    {
        // Arrange
        $this->expectException(PasswordMustHaveDigitException::class);

        // Act, Assert
        Password::fromString('zaertyDghjP');
    }

    final public function testCreateWithNoSpecCharThrowADomainException(): void
    {
        // Arrange
        $this->expectException(PasswordMustHaveSpecialCharactersException::class);

        // Act, Assert
        Password::fromString('zaer5RTYJ5l');
    }
}
