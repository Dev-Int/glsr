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
use Administration\Application\Supplier\ReadModel\Suppliers;
use Administration\Domain\Supplier\Model\Supplier as SupplierModel;
use Administration\Domain\Supplier\Model\VO\SupplierUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineSupplierFinder extends ServiceEntityRepository implements SupplierFinderProtocol
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupplierModel::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByUuid(string $uuid): SupplierModel
    {
        $result = $this->createQueryBuilder('s')
            ->where('s.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return new SupplierModel(
            SupplierUuid::fromString($result->getUuid()),
            NameField::fromString($result->getName()),
            $result->getAddress(),
            $result->getZipCode(),
            $result->getTown(),
            $result->getCountry(),
            PhoneField::fromString($result->getPhone()),
            PhoneField::fromString($result->getFacsimile()),
            EmailField::fromString($result->getEmail()),
            $result->getContact(),
            PhoneField::fromString($result->getCellphone()),
            $result->getFamilyLog(),
            $result->getDelayDelivery(),
            $result->getOrderDay()
        );
    }

    public function findAllActive(): Suppliers
    {
        $statement = $this->createQueryBuilder('s')
            ->getQuery()
            ->getResult()
        ;

        return new Suppliers(
            ...\array_map(static function (SupplierModel $supplier) {
                return new SupplierModel(
                    $supplier->uuid(),
                    $supplier->name(),
                    $supplier->address(),
                    $supplier->zipCode(),
                    $supplier->town(),
                    $supplier->country(),
                    $supplier->phone(),
                    $supplier->facsimile(),
                    $supplier->email(),
                    $supplier->contact(),
                    $supplier->cellphone(),
                    $supplier->familyLog(),
                    $supplier->delayDelivery(),
                    $supplier->orderDays()
                );
            }, $statement)
        );
    }
}
