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
use Core\Domain\Common\Model\VO\ContactUuid;
use Core\Domain\Common\Model\VO\EmailField;
use Core\Domain\Common\Model\VO\NameField;
use Core\Domain\Common\Model\VO\PhoneField;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class DoctrineCompanyRepository implements CompanyRepositoryProtocol
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    final public function existsWithName(string $name): bool
    {
        $query = <<<'SQL'
SELECT uuid FROM company
WHERE name = :name
SQL;
        $statement = $this->connection->executeQuery($query, ['name' => $name])->fetchOne();

        return !(false === $statement);
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    final public function add(Company $company): void
    {
        $data = $this->getData($company);

        $statement = $this->connection->prepare(
            'INSERT INTO company
(uuid, name, address, zip_code, town, country, phone, facsimile, email, contact_name, cellphone, slug)
VALUES
(:uuid, :name, :address, :zip_code, :town, :country, :phone, :facsimile, :email, :contact_name, :cellphone, :slug)'
        );
        $statement->execute($data);
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    final public function update(Company $company): void
    {
        $data = $this->getData($company);

        $statement = $this->connection->prepare(
            'UPDATE company SET
name = :name, address = :address, zip_code = :zip_code, town = :town, country = :country, phone = :phone,
facsimile = :facsimile, email = :email, contact_name = :contact_name, cellphone = :cellphone, slug = :slug
WHERE uuid = :uuid
'
        );
        $statement->execute($data);
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    final public function delete(string $uuid): void
    {
        $statement = $this->connection->prepare('DELETE FROM company WHERE uuid = :uuid');
        $statement->bindParam('uuid', $uuid);
        $statement->execute();
    }

    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    final public function findOneByUuid(string $uuid): ?Company
    {
        $query = <<<'SQL'
SELECT
    company.uuid as uuid,
    company.name as name,
    company.address as address,
    company.zip_code as zipCode,
    company.town as town,
    company.country as country,
    company.phone as phone,
    company.facsimile as facsimile,
    company.email as email,
    company.contact_name as contactName,
    company.cellphone as cellphone,
    company.slug as slug
FROM company
WHERE uuid = :uuid
SQL;
        $result = $this->connection->executeQuery($query, ['uuid' => $uuid])->fetchAssociative();

        return Company::create(
            ContactUuid::fromString($result['uuid']),
            NameField::fromString($result['name']),
            $result['address'],
            $result['zipCode'],
            $result['town'],
            $result['country'],
            PhoneField::fromString($result['phone']),
            PhoneField::fromString($result['facsimile']),
            EmailField::fromString($result['email']),
            $result['contactName'],
            PhoneField::fromString($result['cellphone'])
        );
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    final public function companyExist(): bool
    {
        $query = <<<'SQL'
SELECT uuid FROM company
SQL;
        $statement = $this->connection->executeQuery($query)->fetchOne();

        return !(false === $statement);
    }

    private function getData(Company $company): array
    {
        return [
            'uuid' => $company->uuid(),
            'name' => $company->name(),
            'address' => $company->address(),
            'zip_code' => $company->zipCode(),
            'town' => $company->town(),
            'country' => $company->country(),
            'phone' => $company->phone(),
            'facsimile' => $company->facsimile(),
            'email' => $company->email(),
            'contact_name' => $company->contact(),
            'cellphone' => $company->cellphone(),
            'slug' => $company->slug(),
        ];
    }
}
