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

namespace Administration\Infrastructure\Resources\doctrine;

use DbalSchema\SchemaDefinition;
use Doctrine\DBAL\Schema\Schema;

class GlsrDefinition implements SchemaDefinition
{
    public function define(Schema $schema): void
    {
        // Messenger definition
        $messengerTable = $schema->createTable('messenger_messages');
        $messengerTable->addColumn('id', 'bigint', ['autoincrement' => true]);
        $messengerTable->addColumn('body', 'text');
        $messengerTable->addColumn('headers', 'text');
        $messengerTable->addColumn('queue_name', 'string', ['length' => 190]);
        $messengerTable->addColumn('created_at', 'datetime');
        $messengerTable->addColumn('available_at', 'datetime');
        $messengerTable->addColumn('delivered_at', 'datetime', ['notnull' => false]);
        $messengerTable->addIndex(['queue_name']);
        $messengerTable->addIndex(['available_at']);
        $messengerTable->addIndex(['delivered_at']);
        $messengerTable->setPrimaryKey(['id']);

        // Company definition
        $companyTable = $schema->createTable('company');
        $companyTable->addColumn('uuid', 'string', ['length' => 36]);
        $companyTable->addColumn('name', 'string', ['length' => 150]);
        $companyTable->addColumn('address', 'string');
        $companyTable->addColumn('zip_code', 'string', ['length' => 5]);
        $companyTable->addColumn('town', 'string');
        $companyTable->addColumn('country', 'string');
        $companyTable->addColumn('phone', 'string', ['length' => 12]);
        $companyTable->addColumn('facsimile', 'string', ['notnull' => false, 'length' => 12]);
        $companyTable->addColumn('email', 'string');
        $companyTable->addColumn('contact_name', 'string');
        $companyTable->addColumn('cellphone', 'string', ['length' => 12]);
        $companyTable->addColumn('slug', 'string');
        $companyTable->setPrimaryKey(['uuid']);

        // Settings definition
        $settingsTable = $schema->createTable('settings');
        $settingsTable->addColumn('uuid', 'string', ['length' => 36]);
        $settingsTable->addColumn('currency', 'string', ['length' => 20]);
        $settingsTable->addColumn('locale', 'string', ['length' => 10]);
        $settingsTable->setPrimaryKey(['uuid']);

        // User definition
        $userTable = $schema->createTable('user');
        $userTable->addColumn('uuid', 'string', ['length' => 36]);
        $userTable->addColumn('username', 'string', ['length' => 150]);
        $userTable->addColumn('email', 'string');
        $userTable->addColumn('password', 'string', ['length' => 120]);
        $userTable->addColumn('roles', 'simple_array');
        $userTable->setPrimaryKey(['uuid']);

        // Supplier definition
        $supplierTable = $schema->createTable('supplier');
        $supplierTable->addColumn('uuid', 'string', ['length' => 36]);
        $supplierTable->addColumn('name', 'string', ['length' => 150]);
        $supplierTable->addColumn('address', 'string');
        $supplierTable->addColumn('zip_code', 'string', ['length' => 5]);
        $supplierTable->addColumn('town', 'string');
        $supplierTable->addColumn('country', 'string');
        $supplierTable->addColumn('phone', 'string', ['length' => 12]);
        $supplierTable->addColumn('facsimile', 'string', ['notnull' => false, 'length' => 12]);
        $supplierTable->addColumn('email', 'string');
        $supplierTable->addColumn('contact_name', 'string');
        $supplierTable->addColumn('cellphone', 'string', ['length' => 12]);
        $supplierTable->addColumn('family_log', 'string');
        $supplierTable->addColumn('delay_delivery', 'integer');
        $supplierTable->addColumn('order_days', 'simple_array');
        $supplierTable->addColumn('slug', 'string');
        $supplierTable->addColumn('active', 'smallint', ['length' => 1]);
        $supplierTable->setPrimaryKey(['uuid']);
        $supplierTable->addUniqueIndex(['name']);
        $supplierTable->addUniqueIndex(['slug']);
    }
}
