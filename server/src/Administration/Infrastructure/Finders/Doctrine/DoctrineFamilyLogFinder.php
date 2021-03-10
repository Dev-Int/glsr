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

use Administration\Application\FamilyLog\ReadModel\FamilyLog as FamilyLogReadModel;
use Administration\Application\FamilyLog\ReadModel\FamilyLogs;
use Administration\Application\Protocol\Finders\FamilyLogFinderProtocol;
use Administration\Infrastructure\FamilyLog\Mapper\FamilyLogModelMapper;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;

class DoctrineFamilyLogFinder implements FamilyLogFinderProtocol
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function findBySlug(string $slug): FamilyLogReadModel
    {
        $result = $this->connection->createQueryBuilder()
            ->select('uuid', 'parent_id', 'label', 'slug', 'level')
            ->from('family_log')
            ->where('slug = :slug')
            ->setParameter('slug', $slug)
            ->execute()
            ->fetchAssociative()
        ;

        return (new FamilyLogModelMapper())->getReadModelFromDataArray($result);
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function findAll(): FamilyLogs
    {
        $query = <<<'SQL'
WITH RECURSIVE cte (uuid, parent_id, label, slug, level, dir) AS (
    SELECT uuid, parent_id, label, slug, level, CAST(null as CHAR(10)) as dir
    FROM family_log
    UNION
    SELECT f1.uuid, f1.parent_id, f1.label, f1.slug, f1.level, IFNULL(f2.dir, 'down')
    FROM family_log f1
        INNER JOIN cte f2 ON f1.parent_id = f2.uuid AND IFNULL(f2.dir, 'down')='down'
    UNION
    SELECT f1.uuid, f1.parent_id, f1.label, f1.slug, f1.level, IFNULL(f2.dir, 'up')
    FROM family_log f1
            INNER JOIN cte f2 ON f1.parent_id = f2.uuid AND IFNULL(f2.dir, 'up')='up'
)
SELECT DISTINCT uuid, parent_id, label, slug, level FROM cte
ORDER BY level DESC
SQL;

        $results = $this->connection->executeQuery($query)->fetchAllAssociative();

        return (new FamilyLogModelMapper())->getFamilyLogsFromArray($results);
    }
}
