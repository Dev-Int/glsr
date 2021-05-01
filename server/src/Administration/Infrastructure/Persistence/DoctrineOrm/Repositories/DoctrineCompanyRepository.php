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

use Administration\Domain\Company\Model\Company;
use Administration\Domain\Protocol\Repository\CompanyRepositoryProtocol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineCompanyRepository extends ServiceEntityRepository implements CompanyRepositoryProtocol
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function existsWithName(string $name): bool
    {
        $statement = $this->createQueryBuilder('c')
            ->select(['1'])
            ->where('c.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return !(null === $statement);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    final public function add(Company $company): void
    {
        $this->getEntityManager()->persist($company);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws ORMException
     */
    final public function remove(Company $company): void
    {
        $this->getEntityManager()->remove($company);
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function findOneByUuid(string $uuid): ?Company
    {
        return $this->createQueryBuilder('c')
            ->where('c.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function companyExist(): bool
    {
        $statement = $this->createQueryBuilder('c')
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return null !== $statement;
    }
}
