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
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;

class DoctrineSupplierFinder implements SupplierFinderProtocol
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function findOneByUuid(string $uuid): SupplierModel
    {
        $query = <<<'SQL'
SELECT
    supplier.uuid as uuid,
    supplier.name as name,
    supplier.address as address,
    supplier.zip_code as zipCode,
    supplier.town as town,
    supplier.country as country,
    supplier.phone as phone,
    supplier.facsimile as facsimile,
    supplier.email as email,
    supplier.contact_name as contact,
    supplier.cellphone as cellphone,
    supplier.family_log_id as familyLog,
    supplier.delay_delivery as delayDelivery,
    supplier.order_days as orderDays,
    supplier.active as active,
    supplier.slug as slug
FROM supplier
WHERE uuid = :uuid
SQL;
        $result = $this->connection->executeQuery($query, ['uuid' => $uuid])->fetchAssociative();

        if (null === $result) {
            throw new SupplierNotFound();
        }

        return new SupplierModel(
            $result['uuid'],
            $result['name'],
            $result['address'],
            $result['zipCode'],
            $result['town'],
            $result['country'],
            $result['phone'],
            $result['facsimile'],
            $result['email'],
            $result['contact'],
            $result['cellphone'],
            $result['familyLog'],
            (int) $result['delayDelivery'],
            \explode(',', $result['orderDays']),
            $result['slug'],
            $result['active']
        );
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function findAllActive(): Suppliers
    {
        $query = <<<'SQL'
SELECT
    supplier.uuid as uuid,
    supplier.name as name,
    supplier.address as address,
    supplier.zip_code as zipCode,
    supplier.town as town,
    supplier.country as country,
    supplier.phone as phone,
    supplier.facsimile as facsimile,
    supplier.email as email,
    supplier.contact_name as contact,
    supplier.cellphone as cellphone,
    supplier.family_log_id as familyLog,
    supplier.delay_delivery as delayDelivery,
    supplier.order_days as orderDays,
    supplier.active as active,
    supplier.slug as slug
FROM supplier
WHERE active = 1
SQL;
        $result = $this->connection->executeQuery($query)->fetchAllAssociative();

        return new Suppliers(
            ...\array_map(static function (array $supplier) {
                return new SupplierModel(
                    $supplier['uuid'],
                    $supplier['name'],
                    $supplier['address'],
                    $supplier['zipCode'],
                    $supplier['town'],
                    $supplier['country'],
                    $supplier['phone'],
                    $supplier['facsimile'],
                    $supplier['email'],
                    $supplier['contact'],
                    $supplier['cellphone'],
                    $supplier['familyLog'],
                    (int) $supplier['delayDelivery'],
                    \explode(',', $supplier['orderDays']),
                    $supplier['slug'],
                    (bool) $supplier['active']
                );
            }, $result)
        );
    }
}
