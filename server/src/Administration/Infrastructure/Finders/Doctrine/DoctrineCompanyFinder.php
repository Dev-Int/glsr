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
use Administration\Application\Company\ReadModel\Company as CompanyReadModel;
use Administration\Application\Protocol\Finders\CompanyFinderProtocol;
use Administration\Infrastructure\Company\Mapper\CompanyModelMapper;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class DoctrineCompanyFinder implements CompanyFinderProtocol
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function findByUuid(string $uuid): CompanyReadModel
    {
        $query = $this->connection->createQueryBuilder()
            ->select('uuid', 'name', 'address', 'zip_code', 'town', 'country', 'phone', 'facsimile', 'email',
                     'contact_name', 'cellphone', 'slug')
            ->from('company')
            ->where('uuid = ?')
            ->setParameter(0, $uuid)
        ;

        $result = $query->execute()->fetchAssociative();

        return (new CompanyModelMapper())->getReadModelFromArray($result);
    }

    /**
     * @throws Exception
     */
    public function findAll(): Companies
    {
        $query = $this->connection->createQueryBuilder()
            ->select('uuid', 'name', 'address', 'zip_code', 'town', 'country', 'phone', 'facsimile', 'email',
                     'contact_name', 'cellphone', 'slug')
            ->from('company')
        ;

        $result = $query->execute()->fetchAllAssociative();

        return new Companies(
            ...\array_map(static function (array $company) {
                return (new CompanyModelMapper())->getReadModelFromArray($company);
            }, $result)
        );
    }
}
