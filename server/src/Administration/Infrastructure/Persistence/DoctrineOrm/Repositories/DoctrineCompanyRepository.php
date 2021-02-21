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
use Administration\Infrastructure\Company\Mapper\CompanyModelMapper;
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
     */
    final public function existsWithName(string $name): bool
    {
        $query = $this->connection->createQueryBuilder()
            ->select('name')
            ->from('company')
            ->where('name = :name')
            ->setParameter('name', $name)
        ;
        $statement = $query->execute()->fetchOne();

        return !(false === $statement);
    }

    /**
     * @throws Exception
     */
    final public function add(Company $company): void
    {
        $data = (new CompanyModelMapper())->getDataFromCompany($company);

        $query = $this->connection->createQueryBuilder()
            ->insert('company')
            ->values([
                'uuid' => '?', 'name' => '?', 'address' => '?', 'zip_code' => '?', 'town' => '?', 'country' => '?',
                'phone' => '?', 'facsimile' => '?', 'email' => '?', 'contact_name' => '?', 'cellphone' => '?',
                'slug' => '?',
            ])
            ->setParameters([
                $data['uuid'], $data['name'], $data['address'], $data['zip_code'], $data['town'],
                $data['country'], $data['phone'], $data['facsimile'], $data['email'], $data['contact_name'],
                $data['cellphone'], $data['slug'],
            ])
        ;
        $query->execute();
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    final public function update(Company $company): void
    {
        $data = (new CompanyModelMapper())->getDataFromCompany($company);

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
     */
    final public function delete(string $uuid): void
    {
        $statement = $this->connection->createQueryBuilder()
            ->delete('company')
            ->where('uuid = ?')
            ->setParameter(0, $uuid)
        ;
        $statement->execute();
    }

    /**
     * @throws Exception
     */
    final public function findOneByUuid(string $uuid): ?Company
    {
        $query = $this->connection->createQueryBuilder()
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
                'slug'
            )
            ->from('company')
            ->where('uuid = ?')
            ->setParameter(0, $uuid)
        ;

        $result = $query->execute()->fetchAssociative();

        return (new CompanyModelMapper())->getDomainModelFromArray($result);
    }

    /**
     * @throws Exception
     */
    final public function exists(): bool
    {
        $query = $this->connection->createQueryBuilder()
            ->select('uuid')
            ->from('company')
        ;
        $statement = $query->execute()->fetchOne();

        return false !== $statement;
    }
}
