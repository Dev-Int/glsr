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

namespace Administration\Infrastructure\Finders\DoctrineOrm;

use Administration\Application\Protocol\Finders\UserFinderProtocol;
use Administration\Application\User\ReadModel\User as UserReadModel;
use Administration\Application\User\ReadModel\Users;
use Administration\Domain\User\Model\User as UserDomainModel;
use Administration\Domain\User\Model\VO\UserUuid;
use Administration\Infrastructure\Finders\Exceptions\UserNotFound;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Infrastructure\Persistence\DoctrineOrm\Entities\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineUserFinder extends ServiceEntityRepository implements UserFinderProtocol
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByUsername(string $username): UserDomainModel
    {
        $result = $this->createQueryBuilder('u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
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

    /**
     * @throws NonUniqueResultException
     */
    final public function findOneByUuid(string $uuid): UserDomainModel
    {
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
            ...\array_map(static function (User $user) {
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
