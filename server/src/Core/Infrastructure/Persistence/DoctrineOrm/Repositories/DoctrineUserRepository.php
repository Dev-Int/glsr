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

namespace Core\Infrastructure\Persistence\DoctrineOrm\Repositories;

use Core\Domain\Model\User as UserSymfony;
use Core\Domain\Protocol\Repository\UserRepositoryProtocol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineUserRepository extends ServiceEntityRepository implements UserRepositoryProtocol
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSymfony::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function findOneByUuid(string $uuid): ?UserSymfony
    {
        return $this->createQueryBuilder('u')
            ->where('u.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
