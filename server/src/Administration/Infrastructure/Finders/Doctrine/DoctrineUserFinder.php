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
use Administration\Domain\User\Model\VO\UserUuid;
use Administration\Infrastructure\Finders\Exceptions\UserNotFound;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Model\User as UserDomainModel;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;

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
    public function findOneByUsername(string $username): UserDomainModel
    {
        $query = <<<'SQL'
SELECT * FROM user
WHERE username = :username
SQL;
        $result = $this->connection->executeQuery($query, ['username' => $username])->fetchOne();

        if (null === $result) {
            throw new UserNotFound();
        }

        return new UserDomainModel(
            UserUuid::fromString($result['uuid']),
            NameField::fromString($result['username']),
            EmailField::fromString($result['email']),
            $result['password'],
            $result['roles']
        );
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function findOneByUuid(string $uuid): UserDomainModel
    {
        $query =
        $result = $this->createQueryBuilder('u')
            ->where('u.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (null === $result) {
            throw new UserNotFound();
        }

        return new UserDomainModel(
            UserUuid::fromString($result->getUuid()),
            NameField::fromString($result->getUsername()),
            EmailField::fromString($result->getEmail()),
            $result->getPassword(),
            $result->getRoles()
        );
    }

    final public function findAllUsers(): Users
    {
        $statement = $this->createQueryBuilder('u')
            ->getQuery()
            ->getResult()
        ;

        return new Users(
            ...\array_map(static function (UserDomainModel $user) {
                return new UserReadModel(
                    $user->getUuid(),
                    $user->getUsername(),
                    $user->getEmail(),
                    $user->getPassword(),
                    $user->getRoles()
                );
            }, $statement)
        );
    }
}
