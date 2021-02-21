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

namespace Administration\Infrastructure\Persistence\DoctrineOrm\Repositories;

use Administration\Domain\Protocol\Repository\UserRepositoryProtocol;
use Administration\Domain\User\Model\User;
use Administration\Domain\User\Model\VO\UserUuid;
use Administration\Infrastructure\User\Mapper\UserModelMapper;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class DoctrineUserRepository implements UserRepositoryProtocol
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    final public function add(User $user): void
    {
        $data = (new UserModelMapper())->getDataFromUser($user);

        $this->connection->createQueryBuilder()
            ->insert('user')
            ->values(['uuid' => '?', 'username' => '?', 'email' => '?', 'password' => '?', 'roles' => '?'])
            ->setParameters([$data['uuid'], $data['username'], $data['email'], $data['password'], $data['roles']])
            ->execute()
        ;
    }

    /**
     * @throws Exception
     */
    final public function update(User $user): void
    {
        $data = (new UserModelMapper())->getDataFromUser($user);

        $this->connection->createQueryBuilder()
            ->update('user')
            ->set('username', '?')
            ->set('email', '?')
            ->set('password', '?')
            ->set('roles', '?')
            ->where('uuid = ?')
            ->setParameters([0 => $data['username'], 1 => $data['email'], 2 => $data['password'],
                3 => $data['roles'], 4 => $data['uuid'], ])
            ->execute()
        ;
    }

    /**
     * @throws Exception
     */
    final public function delete(string $uuid): void
    {
        $this->connection->createQueryBuilder()
            ->delete('user')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->execute()
        ;
    }

    /**
     * @throws Exception
     */
    final public function findOneByUuid(string $uuid): ?User
    {
        $result = $this->connection->createQueryBuilder()
            ->select('uuid', 'username', 'email', 'password', 'roles')
            ->from('user')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->execute()
            ->fetchAssociative()
        ;

        return User::create(
            UserUuid::fromString($uuid),
            NameField::fromString($result['username']),
            EmailField::fromString($result['email']),
            '',
            \explode(',', $result['roles'])
        );
    }

    /**
     * @throws Exception
     */
    final public function existWithUsername(string $username): bool
    {
        $statement = $this->connection->createQueryBuilder()
            ->select('username')
            ->from('user')
            ->where('username = :username')
            ->setParameter('username', $username)
            ->execute()
            ->fetchOne()
        ;

        return false !== $statement;
    }

    /**
     * @throws Exception
     */
    final public function existWithEmail(string $email): bool
    {
        $statement = $this->connection->createQueryBuilder()
            ->select('email')
            ->from('user')
            ->where('email = :email')
            ->setParameter('email', $email)
            ->execute()
            ->fetchOne()
        ;

        return false !== $statement;
    }
}
