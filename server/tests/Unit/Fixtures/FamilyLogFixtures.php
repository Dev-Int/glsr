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

namespace Unit\Tests\Fixtures;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class FamilyLogFixtures implements FixturesProtocol
{
    /**
     * @throws \Doctrine\DBAL\Driver\Exception|Exception
     */
    public function load(Connection $connection): void
    {
        $familyLogs = [
            [
                'uuid' => '626adfca-fc5d-415c-9b7a-7541030bd147',
                'label' => 'Surgelé',
                'parent_id' => null,
                'slug' => 'surgele',
                'level' => 1,
                'path' => 'surgele',
            ],
            [
                'uuid' => '8413b485-e1c9-4e79-94e3-ce280986a952',
                'label' => 'Frais',
                'parent_id' => null,
                'slug' => 'frais',
                'level' => 1,
                'path' => 'frais',
            ],
            [
                'uuid' => 'ec9689bb-99d3-4493-b39d-a5b623bba5a0',
                'label' => 'Viande',
                'parent_id' => '626adfca-fc5d-415c-9b7a-7541030bd147',
                'slug' => 'viande',
                'level' => 2,
                'path' => 'surgele/viande',
            ],
        ];

        $statement = $connection->prepare('INSERT INTO family_log
(uuid, parent_id, label, slug, level, path) VALUES (:uuid, :parent_id, :label, :slug, :level, :path)');

        foreach ($familyLogs as $familyLog) {
            $statement->execute($familyLog);
        }
    }
}
