<?php

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
            ['admin']
        );

        // Assert
        self::assertEquals(
            new User(
                UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Laurent'),
                EmailField::fromString('laurent@example.com'),
                'password',
                ['admin']
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
            ['admin']
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
                ['admin']
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
            ['admin']
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
                ['admin']
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
            ['admin']
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
                ['admin']
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
            ['admin']
        );

        // Act
        $user->assignRoles(['admin', 'otherRole']);

        // Assert
        self::assertEquals(
            new User(
                UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
                NameField::fromString('Laurent'),
                EmailField::fromString('laurent@example.com'),
                'password',
                ['admin', 'otherRole']
            ),
            $user
        );
    }
}
