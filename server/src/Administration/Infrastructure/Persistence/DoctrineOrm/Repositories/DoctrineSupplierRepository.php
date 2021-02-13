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

use Administration\Domain\Protocol\Repository\SupplierRepositoryProtocol;
use Administration\Domain\Supplier\Model\Supplier;
use Administration\Infrastructure\Finders\Exceptions\SupplierNotFound;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineSupplierRepository extends ServiceEntityRepository implements SupplierRepositoryProtocol
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

    public function remove(Supplier $supplier): void
    {
        // TODO: Implement remove() method.
    }

    /**
     * @throws NonUniqueResultException
     */
    public function existsWithName(string $name): bool
    {
        $statement = $this->createQueryBuilder('ds')
            ->select(['1'])
            ->where('ds.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return !(null === $statement);
    }

    /**
     * @throws ORMException
     */
    public function add(Supplier $supplier): void
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
}
