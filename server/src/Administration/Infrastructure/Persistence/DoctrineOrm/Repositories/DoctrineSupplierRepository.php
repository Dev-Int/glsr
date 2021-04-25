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

use Administration\Infrastructure\Finders\Exceptions\SupplierNotFound;
use Administration\Infrastructure\Persistence\DoctrineOrm\Entities\Supplier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Supplier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supplier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supplier[]    findAll()
 * @method Supplier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoctrineSupplierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function existsWithName(string $companyName): bool
    {
        $statement = $this->createQueryBuilder('ds')
            ->select(['1'])
            ->where('ds.companyName = :companyName')
            ->setParameter('companyName', $companyName)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return null !== $statement;
    }

    /**
     * @throws ORMException
     */
    public function save(Supplier $supplier): void
    {
        $this->getEntityManager()->persist($supplier);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByUuid(string $uuid): Supplier
    {
        $result = $this->createQueryBuilder('s')
            ->where('s.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (null === $result) {
            throw new SupplierNotFound();
        }

        return $result;
    }

    /**
     * @throws ORMException
     */
    final public function remove(Supplier $supplier): void
    {
        $this->getEntityManager()->remove($supplier);
    }
}
