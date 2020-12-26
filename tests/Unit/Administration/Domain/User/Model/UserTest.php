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

namespace Unit\Tests\Administration\Domain\User\Model;

use Administration\Domain\User\Model\User;
use Administration\Domain\User\Model\VO\UserUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    final public function testInstantiateUser(): void
    {
        // Arrange && Act
        $user = User::create(
            UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            'password',
            ['ROLE_ADMIN']
        );

        // Assert
        self::assertEquals(
            new User(
                UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Laurent'),
                EmailField::fromString('laurent@example.com'),
                'password',
                ['ROLE_ADMIN']
            ),
            $user
        );
    }

    final public function testRenameUser(): void
    {
        // Arrange
        $user = User::create(
            UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            'password',
            ['ROLE_ADMIN']
        );

        // Act
        $user->renameUser(NameField::fromString('Arthur'));

        // Assert
        self::assertEquals(
            new User(
                UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Arthur'),
                EmailField::fromString('laurent@example.com'),
                'password',
                ['ROLE_ADMIN']
            ),
            $user
        );
    }

    final public function testChangeEmail(): void
    {
        // Arrange
        $user = User::create(
            UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            'password',
            ['ROLE_ADMIN']
        );

        // Act
        $user->changeEmail(EmailField::fromString('l@example.com'));

        // Assert
        self::assertEquals(
            new User(
                UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Laurent'),
                EmailField::fromString('l@example.com'),
                'password',
                ['ROLE_ADMIN']
            ),
            $user
        );
    }

    final public function testChangePassword(): void
    {
        // Arrange
        $user = User::create(
            UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            'password',
            ['ROLE_ADMIN']
        );

        // Act
        $user->changePassword('otherWord');

        // Assert
        self::assertEquals(
            new User(
                UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Laurent'),
                EmailField::fromString('laurent@example.com'),
                'otherWord',
                ['ROLE_ADMIN']
            ),
            $user
        );
    }

    final public function testAssignRoles(): void
    {
        // Arrange
        $user = User::create(
            UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            'password',
            ['ROLE_ADMIN']
        );

        // Act
        $user->assignRoles(['ROLE_ADMIN', 'ROLE_OTHER']);

        // Assert
        self::assertEquals(
            new User(
                UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Laurent'),
                EmailField::fromString('laurent@example.com'),
                'password',
                ['ROLE_ADMIN', 'ROLE_OTHER']
            ),
            $user
        );
    }
}
