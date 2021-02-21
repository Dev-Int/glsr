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

class SettingsFixtures implements FixturesProtocol
{
    /**
     * @throws Exception
     */
    public function load(Connection $connection): void
    {
        $settings = [
            'uuid' => 'a136c6fe-8f6e-45ed-91bc-586374791033',
            'locale' => 'fr',
            'currency' => 'Euro',
        ];
        $query = $connection->createQueryBuilder()
            ->insert('settings')
            ->values(['uuid' => '?', 'currency' => '?', 'locale' => '?'])
            ->setParameters([$settings['uuid'], $settings['currency'], $settings['locale']])
        ;
        $query->execute();
    }
}
