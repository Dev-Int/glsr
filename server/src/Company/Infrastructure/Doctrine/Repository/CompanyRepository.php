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

namespace Company\Infrastructure\Doctrine\Repository;

use Company\Infrastructure\Doctrine\Entity\Company;
use Core\Domain\Common\Model\VO\ResourceUuidInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    final public function existsWithName(string $companyName): bool
    {
        $statement = $this->createQueryBuilder('c')
            ->select(['1'])
            ->where('c.companyName = :companyName')
            ->setParameter('companyName', $companyName)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return null !== $statement;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    final public function save(Company $company): void
    {
        $this->getEntityManager()->persist($company);
        $this->flush();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    final public function flush(): void
    {
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
    final public function findOneByUuid(ResourceUuidInterface $uuid): ?Company
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
