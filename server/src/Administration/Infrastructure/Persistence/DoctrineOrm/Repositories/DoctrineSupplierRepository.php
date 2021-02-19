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
use Core\Domain\Common\Model\Dependent\FamilyLog;
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;

class DoctrineSupplierRepository implements SupplierRepositoryProtocol
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function existsWithName(string $name): bool
    {
        $query = <<<'SQL'
SELECT uuid FROM supplier
WHERE name = :name
SQL;
        $statement = $this->connection->executeQuery($query, ['name' => $name])->fetchOne();

        return !(false === $statement);
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function add(Supplier $supplier): void
    {
        $data = $this->getData($supplier);

        $statement = $this->connection->prepare(
            'INSERT INTO supplier
(uuid, name, address, zip_code, town, country, phone, facsimile, email, contact_name, cellphone, family_log,
 delay_delivery, order_days, slug, active) VALUES (:uuid, :name, :address, :zip_code, :town, :country, :phone,
:facsimile, :email, :contact_name, :cellphone, :family_log, :delay_delivery, :order_days, :slug, :active)'
        );
        $statement->execute($data);
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function update(Supplier $supplier): void
    {
        $data = $this->getData($supplier);

        $statement = $this->connection->prepare(
            'UPDATE supplier SET
uuid = :uuid, name = :name, address = :address, zip_code = :zip_code, town = :town, country = :country, phone = :phone,
facsimile = :facsimile, email = :email, contact_name = :contact_name, cellphone = :cellphone, family_log = :family_log,
delay_delivery = :delay_delivery, order_days = :order_days, slug = :slug, active = :active
WHERE uuid = :uuid'
        );
        $statement->execute($data);
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function findOneByUuid(string $uuid): Supplier
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
    supplier.family_log as familyLog,
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

        return Supplier::create(
            ContactUuid::fromString($result['uuid']),
            NameField::fromString($result['name']),
            $result['address'],
            $result['zipCode'],
            $result['town'],
            $result['country'],
            PhoneField::fromString($result['phone']),
            PhoneField::fromString($result['facsimile']),
            EmailField::fromString($result['email']),
            $result['contact'],
            PhoneField::fromString($result['cellphone']),
            FamilyLog::create(NameField::fromString($result['familyLog'])),
            (int) $result['delayDelivery'],
            \explode(',', $result['orderDays']),
        );
    }

    private function getData(Supplier $supplier): array
    {
        return [
            'uuid' => $supplier->uuid(),
            'name' => $supplier->name(),
            'address' => $supplier->address(),
            'zip_code' => $supplier->zipCode(),
            'town' => $supplier->town(),
            'country' => $supplier->country(),
            'phone' => $supplier->phone(),
            'facsimile' => $supplier->facsimile(),
            'email' => $supplier->email(),
            'contact_name' => $supplier->contact(),
            'cellphone' => $supplier->cellphone(),
            'family_log' => $supplier->familyLog(),
            'delay_delivery' => $supplier->delayDelivery(),
            'order_days' => \implode(',', $supplier->orderDays()),
            'slug' => $supplier->slug(),
            'active' => (int) $supplier->isActive(),
        ];
    }
}
