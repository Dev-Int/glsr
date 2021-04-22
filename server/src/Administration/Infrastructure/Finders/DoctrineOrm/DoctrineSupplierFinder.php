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

use Administration\Application\Protocol\Finders\SupplierFinderProtocol;
use Administration\Application\Supplier\ReadModel\Supplier as SupplierReadModel;
use Administration\Application\Supplier\ReadModel\Suppliers;
use Administration\Infrastructure\Persistence\DoctrineOrm\Entities\Supplier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineSupplierFinder extends ServiceEntityRepository implements SupplierFinderProtocol
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByUuid(string $uuid): SupplierReadModel
    {
        $result = $this->createQueryBuilder('s')
            ->where('s.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return new SupplierReadModel(
            $result->getUuid(),
            $result->getName(),
            $result->getAddress(),
            $result->getZipCode(),
            $result->getTown(),
            $result->getCountry(),
            $result->getPhone(),
            $result->getFacsimile(),
            $result->getEmail(),
            $result->getContact(),
            $result->getCellphone(),
            $result->getFamilyLog(),
            $result->getDelayDelivery(),
            $result->getOrderDay(),
            $result->getSlug()
        );
    }

    public function findAllActive(): Suppliers
    {
        $statement = $this->createQueryBuilder('s')
            ->where('s.active = 1')
            ->getQuery()
            ->getResult()
        ;

        return new Suppliers(
            ...\array_map(static function (Supplier $supplier) {
                return new SupplierReadModel(
                    $supplier->getUuid(),
                    $supplier->getCompanyName(),
                    $supplier->getAddress(),
                    $supplier->getZipCode(),
                    $supplier->getTown(),
                    $supplier->getCountry(),
                    $supplier->getPhone(),
                    $supplier->getFacsimile(),
                    $supplier->getEmail(),
                    $supplier->getContactName(),
                    $supplier->getCellphone(),
                    $supplier->getFamilyLog(),
                    $supplier->getDelayDelivery(),
                    $supplier->getOrderDays(),
                    $supplier->getSlug()
                );
            }, $statement)
        );
    }
}
