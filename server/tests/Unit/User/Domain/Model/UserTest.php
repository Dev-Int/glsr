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

namespace Unit\Tests\User\Domain\Model;

use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\ResourceUuid;
use PHPUnit\Framework\TestCase;
use User\Domain\Model\User;
use User\Domain\Model\VO\Password;

class UserTest extends TestCase
{
    final public function testInstantiateUser(): void
    {
        // Arrange && Act
        $user = User::create(
            ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            Password::fromString('Password-1'),
            ['ROLE_ADMIN']
        );

        // Assert
        self::assertEquals(
            new User(
                ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Laurent'),
                EmailField::fromString('laurent@example.com'),
                Password::fromString('Password-1'),
                ['ROLE_ADMIN']
            ),
            $user
        );
    }

    final public function testRenameUser(): void
    {
        // Arrange
        $user = User::create(
            ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            Password::fromString('Password-1'),
            ['ROLE_ADMIN']
        );

        // Act
        $user->renameUser(NameField::fromString('Arthur'));

        // Assert
        self::assertEquals(
            new User(
                ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Arthur'),
                EmailField::fromString('laurent@example.com'),
                Password::fromString('Password-1'),
                ['ROLE_ADMIN']
            ),
            $user
        );
    }

    final public function testChangeEmail(): void
    {
        // Arrange
        $user = User::create(
            ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            Password::fromString('Password-1'),
            ['ROLE_ADMIN']
        );

        // Act
        $user->changeEmail(EmailField::fromString('l@example.com'));

        // Assert
        self::assertEquals(
            new User(
                ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Laurent'),
                EmailField::fromString('l@example.com'),
                Password::fromString('Password-1'),
                ['ROLE_ADMIN']
            ),
            $user
        );
    }

    final public function testChangePassword(): void
    {
        // Arrange
        $user = User::create(
            ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            Password::fromString('Password-1'),
            ['ROLE_ADMIN']
        );

        // Act
        $user->changePassword(Password::fromString('otherWord-2'));

        // Assert
        self::assertEquals(
            new User(
                ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Laurent'),
                EmailField::fromString('laurent@example.com'),
                Password::fromString('otherWord-2'),
                ['ROLE_ADMIN']
            ),
            $user
        );
    }

    final public function testAssignRoles(): void
    {
        // Arrange
        $user = User::create(
            ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            Password::fromString('Password-1'),
            ['ROLE_ADMIN']
        );

        // Act
        $user->assignRoles(['ROLE_ADMIN', 'ROLE_OTHER']);

        // Assert
        self::assertEquals(
            new User(
                ResourceUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Laurent'),
                EmailField::fromString('laurent@example.com'),
                Password::fromString('Password-1'),
                ['ROLE_ADMIN', 'ROLE_OTHER']
            ),
            $user
        );
    }
}
