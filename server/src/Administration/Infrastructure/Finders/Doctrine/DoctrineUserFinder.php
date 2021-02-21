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
use Administration\Infrastructure\User\Mapper\UserModelMapper;
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
     */
    public function findOneByUsername(string $username): UserReadModel
    {
        $result = $this->connection->createQueryBuilder()
            ->select('uuid', 'username', 'email', 'password', 'roles')
            ->from('user')
            ->where('username = :username')
            ->setParameter('username', $username)
            ->execute()
            ->fetchAssociative()
        ;

        if (false === $result) {
            throw new UserNotFound();
        }

        return (new UserModelMapper())->getReadModelFromArray($result);
    }

    /**
     * @throws Exception
     */
    final public function findOneByUuid(string $uuid): UserReadModel
    {
        $result = $this->connection->createQueryBuilder()
            ->select('uuid', 'username', 'email', 'password', 'roles')
            ->from('user')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->execute()
            ->fetchAssociative()
        ;

        if (false === $result) {
            throw new UserNotFound();
        }

        return (new UserModelMapper())->getReadModelFromArray($result);
    }

    /**
     * @throws Exception
     */
    final public function findAllUsers(): Users
    {
        $result = $this->connection->createQueryBuilder()
            ->select('uuid', 'username', 'email', 'password', 'roles')
            ->from('user')
            ->execute()
            ->fetchAllAssociative()
        ;

        return new Users(
            ...\array_map(static function (array $user) {
                return (new UserModelMapper())->getReadModelFromArray($user);
            }, $result)
        );
    }
}
