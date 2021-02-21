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

use Administration\Application\Protocol\Finders\SupplierFinderProtocol;
use Administration\Application\Supplier\ReadModel\Supplier as SupplierModel;
use Administration\Application\Supplier\ReadModel\Suppliers;
use Administration\Infrastructure\Finders\Exceptions\SupplierNotFound;
use Administration\Infrastructure\Supplier\SupplierModelMapper;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class DoctrineSupplierFinder implements SupplierFinderProtocol
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function findOneByUuid(string $uuid): SupplierModel
    {
        $result = $this->connection->createQueryBuilder()
            ->select(
                'uuid',
                'name',
                'address',
                'zip_code',
                'town',
                'country',
                'phone',
                'facsimile',
                'email',
                'contact_name',
                'cellphone',
                'family_log',
                'delay_delivery',
                'order_days',
                'slug',
                'active'
            )
            ->from('supplier')
            ->where('uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->execute()
            ->fetchAssociative()
        ;

        if (null === $result) {
            throw new SupplierNotFound();
        }

        return (new SupplierModelMapper())->getReadModelFromArray($result);
    }

    /**
     * @throws Exception
     */
    public function findAllActive(): Suppliers
    {
        $result = $this->connection->createQueryBuilder()
            ->select(
                'uuid',
                'name',
                'address',
                'zip_code',
                'town',
                'country',
                'phone',
                'facsimile',
                'email',
                'contact_name',
                'cellphone',
                'family_log',
                'delay_delivery',
                'order_days',
                'slug',
                'active'
            )
            ->from('supplier')
            ->execute()
            ->fetchAllAssociative()
        ;

        return new Suppliers(
            ...\array_map(static function (array $supplier) {
                return (new SupplierModelMapper())->getReadModelFromArray($supplier);
            }, $result)
        );
    }
}
