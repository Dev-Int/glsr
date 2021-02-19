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

class CompanyFixtures implements FixturesProtocol
{
    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function load(Connection $connection): void
    {
        $company = [
            'uuid' => 'a136c6fe-8f6e-45ed-91bc-586374791033',
            'name' => 'Dev-Int Création',
            'address' => '1 rue des ERP',
            'zip_code' => '75000',
            'town' => 'PARIS',
            'country' => 'France',
            'phone' => '0100000001',
            'facsimile' => '0100000002',
            'email' => 'contact@developpement-interessant.com',
            'contact_name' => 'Laurent',
            'cellphone' => '0600000001',
            'slug' => 'dev-int-creation',
        ];

        $statement = $connection->prepare(
            'INSERT INTO company
(uuid, name, address, zip_code, town, country, phone, facsimile, email, contact_name, cellphone, slug)
VALUES
(:uuid, :name, :address, :zip_code, :town, :country, :phone, :facsimile, :email, :contact_name, :cellphone, :slug)'
        );
        $statement->execute($company);
    }
}
