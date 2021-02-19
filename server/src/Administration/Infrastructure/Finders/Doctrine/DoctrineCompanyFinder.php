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

use Administration\Application\Company\ReadModel\Companies;
use Administration\Application\Company\ReadModel\Company as CompanyModel;
use Administration\Application\Protocol\Finders\CompanyFinderProtocol;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;

class DoctrineCompanyFinder implements CompanyFinderProtocol
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function findByUuid(string $uuid): CompanyModel
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
        $result = $this->connection->executeQuery($query, ['uuid' => $uuid])->fetchOne();

        return new CompanyModel(
            $result['uuid'],
            $result['name'],
            $result['address'],
            $result['zipCode'],
            $result['town'],
            $result['country'],
            $result['phone'],
            $result['facsimile'],
            $result['email'],
            $result['contactName'],
            $result['cellphone'],
            $result['slug']
        );
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function findAll(): Companies
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
    company.contact_name as contact,
    company.cellphone as cellphone,
    company.slug as slug
FROM company
ORDER BY name
SQL;
        $result = $this->connection->executeQuery($query)->fetchAllAssociative();

        return new Companies(
            ...\array_map(static function (array $company) {
                return new CompanyModel(
                    $company['uuid'],
                    $company['name'],
                    $company['address'],
                    $company['zipCode'],
                    $company['town'],
                    $company['country'],
                    $company['phone'],
                    $company['facsimile'],
                    $company['email'],
                    $company['contact'],
                    $company['cellphone'],
                    $company['slug']
                );
            }, $result)
        );
    }
}
