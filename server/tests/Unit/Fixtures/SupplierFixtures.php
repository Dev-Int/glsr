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
use Doctrine\DBAL\Driver\Exception;

class SupplierFixtures implements FixturesProtocol
{
    /**
     * @throws \Doctrine\DBAL\Exception|Exception
     */
    public function load(Connection $connection): void
    {
        $supplier = [
            'uuid' => 'a136c6fe-8f6e-45ed-91bc-586374791033',
            'name' => 'Davigel',
            'address' => '1 rue des freezes',
            'zip_code' => '75000',
            'town' => 'PARIS',
            'country' => 'France',
            'phone' => '0100000001',
            'facsimile' => '0100000002',
            'email' => 'contact@developpement-interessant.com',
            'contact_name' => 'Laurent',
            'cellphone' => '0600000001',
            'family_log_id' => '626adfca-fc5d-415c-9b7a-7541030bd147',
            'delay_delivery' => 1,
            'order_days' => \implode(',', [1, 5]),
            'slug' => 'davigel',
            'active' => 1,
        ];

        $statement = $connection->prepare(
            'INSERT INTO supplier
(uuid, name, address, zip_code, town, country, phone, facsimile, email, contact_name, cellphone, family_log_id,
 delay_delivery, order_days, slug, active) VALUES (:uuid, :name, :address, :zip_code, :town, :country, :phone,
:facsimile, :email, :contact_name, :cellphone, :family_log_id, :delay_delivery, :order_days, :slug, :active)'
        );
        $statement->execute($supplier);
    }
}
