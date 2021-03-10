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
        $familyLog = [
            'uuid' => 'a136c6fe-8f6e-45ed-91bc-586374791033',
            'label' => 'Surgelé',
            'parent_id' => null,
            'slug' => 'surgele',
            'level' => 1,
        ];

        $statement = $connection->prepare('INSERT INTO family_log
(uuid, parent_id, label, slug, level) VALUES (:uuid, :parent, :label, :slug, :level)');
        $statement->execute($familyLog);
    }
}
