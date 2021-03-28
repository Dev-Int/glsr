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

use Administration\Domain\FamilyLog\Model\FamilyLog;
use Administration\Domain\Protocol\Repository\FamilyLogRepositoryProtocol;
use Administration\Infrastructure\FamilyLog\Mapper\FamilyLogModelMapper;
use Administration\Infrastructure\Finders\Exceptions\FamilyLogNotFound;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception;

class DoctrineFamilyLogRepository implements FamilyLogRepositoryProtocol
{
    protected Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function existWithLabel(string $label, ?string $parentUuid): bool
    {
        $statement = $this->connection->createQueryBuilder()
            ->select('label')
            ->from('family_log')
            ->where('label = :label')
            ->andWhere('parent_id = :parent_id')
            ->setParameters(['label' => $label, 'parent_id' => $parentUuid])
            ->execute()
            ->fetchOne()
        ;

        return false !== $statement;
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function findParent(string $uuid): FamilyLog
    {
        $parent = null;
        $query = <<<'SQL'
WITH RECURSIVE cte (uuid, parent_id, label, level, path, slug, dir) AS (
    SELECT uuid, parent_id, label, level, path, slug, CAST(null as CHAR(10)) as dir
    FROM family_log
    WHERE uuid = :uuid
    UNION
    SELECT f1.uuid, f1.parent_id, f1.label, f1.level, f1.path, f1.slug, IFNULL(f2.dir, 'up')
    FROM family_log f1
        INNER JOIN cte f2 ON f2.parent_id = f1.uuid AND IFNULL(f2.dir, 'up')='up'
)
SELECT DISTINCT uuid, parent_id, label, level, path, slug FROM cte
ORDER BY level
SQL;

        // Get parents
        $result = $this->connection->executeQuery($query, ['uuid' => $uuid])->fetchAllAssociative();

        if ([] === $result) {
            throw new FamilyLogNotFound();
        }

        return (new FamilyLogModelMapper())->createParentTreeFromArray($result);
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function findChildren(string $uuid): FamilyLog
    {
        $children = null;
        $query = <<<'SQL'
WITH RECURSIVE cte (uuid, parent_id, label, level, path, slug, dir) AS (
    SELECT uuid, parent_id, label, level, path, slug, CAST(null as CHAR(10)) as dir
    FROM family_log
    WHERE uuid = :uuid
    UNION
    SELECT f1.uuid, f1.parent_id, f1.label, f1.level, f1.path, f1.slug, IFNULL(f2.dir, 'down')
    FROM family_log f1
        INNER JOIN cte f2 ON f1.parent_id = f2.uuid AND IFNULL(f2.dir, 'down')='down'
)
SELECT DISTINCT uuid, parent_id, label, level, path, slug FROM cte
ORDER BY level
SQL;
        // Get children
        $result = $this->connection->executeQuery($query, ['uuid' => $uuid])->fetchAllAssociative();

        if ([] === $result) {
            throw new FamilyLogNotFound();
        }

        return (new FamilyLogModelMapper())->createChildrenTreeFromArray($result, $uuid);
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function add(FamilyLog $familyLog): void
    {
        $data = $this->getData($familyLog);

        $statement = $this->connection->prepare(
            'INSERT INTO family_log
(uuid, parent_id, label, slug, level, path) VALUES (:uuid, :parent_id, :label, :slug, :level, :path)'
        );
        $statement->execute($data);
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function update(FamilyLog $familyLog): void
    {
        $data = $this->getData($familyLog);

        $statement = $this->connection->prepare(
            'UPDATE family_log SET
uuid = :uuid, parent_id = :parent_id, label = :label, slug = :slug, level = :level, path = :path
WHERE uuid = :uuid'
        );
        $statement->execute($data);
    }

    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function delete(string $familyLogUuid): void
    {
        $statement = $this->connection->prepare('DELETE FROM family_log WHERE uuid = :uuid');
        $statement->execute(['uuid' => $familyLogUuid]);
    }

    private function getData(FamilyLog $familyLog): array
    {
        $parent = null;
        if (null !== $familyLog->parent()) {
            $parent = $familyLog->parent()->uuid();
        }

        return [
            'uuid' => $familyLog->uuid(),
            'parent_id' => $parent,
            'label' => $familyLog->label(),
            'slug' => $familyLog->slug(),
            'level' => (int) $familyLog->level(),
            'path' => $familyLog->path(),
        ];
    }
}
