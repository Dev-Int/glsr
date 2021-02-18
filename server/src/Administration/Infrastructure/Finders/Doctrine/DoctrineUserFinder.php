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

namespace Administration\Infrastructure\Finders\Doctrine;

use Administration\Application\Protocol\Finders\UserFinderProtocol;
use Administration\Application\User\ReadModel\User as UserReadModel;
use Administration\Application\User\ReadModel\Users;
use Administration\Infrastructure\Finders\Exceptions\UserNotFound;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class DoctrineUserFinder implements UserFinderProtocol
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function findOneByUsername(string $username): UserReadModel
    {
        $query = <<<'SQL'
SELECT
    user.uuid as uuid,
    user.username as username,
    user.email as email,
    user.roles as roles
FROM user
WHERE username = :username
SQL;
        $result = $this->connection->executeQuery($query, ['username' => $username])->fetchAssociative();

        if (false === $result) {
            throw new UserNotFound();
        }

        return new UserReadModel(
            $result['uuid'],
            $result['username'],
            $result['email'],
            \explode(',', $result['roles']),
            null,
        );
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function findOneByUuid(string $uuid): UserReadModel
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

        if (false === $result) {
            throw new UserNotFound();
        }

        return new UserReadModel(
            $result['uuid'],
            $result['username'],
            $result['email'],
            \explode(',', $result['roles']),
            null,
        );
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function findAllUsers(): Users
    {
        $query = <<<'SQL'
SELECT
    user.uuid as uuid,
    user.username as username,
    user.email as email,
    user.roles as roles
FROM user
SQL;
        $result = $this->connection->executeQuery($query)->fetchAllAssociative();

        return new Users(
            ...\array_map(static function (array $user) {
                return new UserReadModel(
                    $user['uuid'],
                    $user['username'],
                    $user['email'],
                    \explode(',', $user['roles']),
                    null,
                );
            }, $result)
        );
    }
}
