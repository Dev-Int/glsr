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
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function add(User $user): void
    {
        $data = $this->getData($user);

        $statement = $this->connection->prepare(
            'INSERT INTO user
(uuid, username, email, password, roles) VALUES (:uuid, :username, :email, :password, :roles)'
        );
        $statement->execute($data);
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function update(User $user): void
    {
        $data = $this->getData($user);

        $statement = $this->connection->prepare(
            'UPDATE user SET
uuid = :uuid, username = :username, email = :email, password = :password, roles = :roles
WHERE uuid = :uuid'
        );
        $statement->execute($data);
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function delete(string $uuid): void
    {
        $statement = $this->connection->prepare('DELETE FROM user WHERE uuid = :uuid');
        $statement->bindParam('uuid', $uuid);
        $statement->execute();
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function findOneByUuid(string $uuid): ?User
    {
        $query = <<<'SQL'
SELECT
    user.uuid as uuid,
    user.username as username,
    user.email as email,
    user.roles as roles
FROM user
WHERE uuid = :uuid
SQL;
        $result = $this->connection->executeQuery($query, ['uuid' => $uuid])->fetchAssociative();

        return User::create(
            UserUuid::fromString($uuid),
            NameField::fromString($result['username']),
            EmailField::fromString($result['email']),
            '',
            \explode(',', $result['roles'])
        );
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function existWithUsername(string $username): bool
    {
        $query = <<<'SQL'
SELECT username FROM user
WHERE username = :username
SQL;
        $statement = $this->connection->executeQuery($query, ['username' => $username])->fetchAssociative();

        return false !== $statement;
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function existWithEmail(string $email): bool
    {
        $query = <<<'SQL'
SELECT email FROM user
WHERE email = :email
SQL;
        $statement = $this->connection->executeQuery($query, ['email' => $email])->fetchAssociative();

        return false !== $statement;
    }

    private function getData(User $user): array
    {
        return [
            'uuid' => $user->uuid()->toString(),
            'username' => $user->username(),
            'email' => $user->email()->getValue(),
            'password' => $user->password(),
            'roles' => \implode(',', $user->roles()),
        ];
    }
}
