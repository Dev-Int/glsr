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
use Administration\Infrastructure\Supplier\SupplierModelMapper;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class DoctrineSupplierRepository implements SupplierRepositoryProtocol
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function existsWithName(string $name): bool
    {
        $statement = $this->connection->createQueryBuilder()
            ->select('name')
            ->from('supplier')
            ->where('name = :name')
            ->setParameter('name', $name)
            ->execute()
            ->fetchOne()
        ;

        return false !== $statement;
    }

    /**
     * @throws Exception
     */
    public function add(Supplier $supplier): void
    {
        $data = (new SupplierModelMapper())->getDataFromSupplier($supplier);

        $this->connection->createQueryBuilder()
            ->insert('supplier')
            ->values([
                'uuid' => '?', 'name' => '?', 'address' => '?', 'zip_code' => '?', 'town' => '?',
                'country' => '?', 'phone' => '?', 'facsimile' => '?', 'email' => '?', 'contact_name' => '?',
                'cellphone' => '?', 'family_log' => '?', 'delay_delivery' => '?', 'order_days' => '?', 'slug' => '?',
                'active' => '?',
            ])
            ->setParameters([
                $data['uuid'], $data['name'], $data['address'], $data['zip_code'], $data['town'],
                $data['country'], $data['phone'], $data['facsimile'], $data['email'], $data['contact_name'],
                $data['cellphone'], $data['family_log'], $data['delay_delivery'], $data['order_days'], $data['slug'],
                $data['active'],
            ])
            ->execute()
        ;
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    public function update(Supplier $supplier): void
    {
        $data = (new SupplierModelMapper())->getDataFromSupplier($supplier);

        $this->connection->prepare(
            'UPDATE supplier SET
uuid = :uuid, name = :name, address = :address, zip_code = :zip_code, town = :town, country = :country, phone = :phone,
facsimile = :facsimile, email = :email, contact_name = :contact_name, cellphone = :cellphone, family_log = :family_log,
delay_delivery = :delay_delivery, order_days = :order_days, slug = :slug, active = :active
WHERE uuid = :uuid'
        )->execute($data);
    }

    /**
     * @throws Exception
     */
    public function findOneByUuid(string $uuid): Supplier
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

        return (new SupplierModelMapper())->getDomainModelFromArray($result);
    }
}
