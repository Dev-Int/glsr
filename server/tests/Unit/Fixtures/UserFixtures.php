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

namespace Unit\Tests\Fixtures;

use Administration\Domain\User\Model\VO\UserUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Model\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures implements FixturesProtocol
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    public function load(Connection $connection): void
    {
        $user = new User(
            UserUuid::fromString('a136c6fe-8f6e-45ed-91bc-586374791033'),
            NameField::fromString('Laurent'),
            EmailField::fromString('laurent@example.com'),
            'password',
            ['ROLE_ADMIN'],
        );
        $passwordEncoded = $this->passwordEncoder->encodePassword($user, $user->getPassword());
        $userData = [
            'uuid' => $user->uuid()->toString(),
            'username' => $user->username(),
            'email' => $user->email()->getValue(),
            'password' => $passwordEncoded,
            'roles' => \implode(',', $user->roles()),
        ];

        $statement = $connection->prepare('INSERT INTO user
(uuid, username, email, password, roles) VALUES (:uuid, :username, :email, :password, :roles)');

        $statement->execute($userData);
    }
}
