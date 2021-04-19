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

namespace Administration\Infrastructure\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419202624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update contact extends after refactor (company, supplier)';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_4FBF094F1D4E64E8 ON company');
        $this->addSql(
            'ALTER TABLE company ' .
            'CHANGE name company_name VARCHAR(255) NOT NULL, ' .
            'CHANGE contact contact_name VARCHAR(255) NOT NULL, ' .
            'CHANGE phone phone VARCHAR(14) NOT NULL, ' .
            'CHANGE facsimile facsimile VARCHAR(14) DEFAULT NULL, ' .
            'CHANGE cellphone cellphone VARCHAR(14) NOT NULL, ' .
            'CHANGE zip_code zip_code VARCHAR(5) NOT NULL'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F1D4E64E8 ON company (company_name)');
        $this->addSql('DROP INDEX UNIQ_9B2A6C7E1D4E64E8 ON supplier');
        $this->addSql(
            'ALTER TABLE supplier ' .
            'CHANGE name company_name VARCHAR(255) NOT NULL, ' .
            'CHANGE contact contact_name VARCHAR(255) NOT NULL, ' .
            'CHANGE zip_code zip_code VARCHAR(5) NOT NULL, ' .
            'CHANGE phone phone VARCHAR(14) NOT NULL, ' .
            'CHANGE facsimile facsimile VARCHAR(14) DEFAULT NULL, ' .
            'CHANGE cellphone cellphone VARCHAR(14) NOT NULL'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B2A6C7E1D4E64E8 ON supplier (company_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_4FBF094F1D4E64E8 ON company');
        $this->addSql(
            'ALTER TABLE company ' .
            'CHANGE company_name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ' .
            'CHANGE contact_name contact VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ' .
            'CHANGE zip_code zip_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ' .
            'CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ' .
            'CHANGE facsimile facsimile VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL ' .
            'COLLATE `utf8mb4_unicode_ci`, ' .
            'CHANGE cellphone cellphone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F1D4E64E8 ON company (name)');
        $this->addSql('DROP INDEX UNIQ_9B2A6C7E1D4E64E8 ON supplier');
        $this->addSql(
            'ALTER TABLE supplier ' .
            'CHANGE company_name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ' .
            'CHANGE contact_name contact VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ' .
            'CHANGE zip_code zip_code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ' .
            'CHANGE phone phone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ' .
            'CHANGE facsimile facsimile VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL ' .
            'COLLATE `utf8mb4_unicode_ci`, ' .
            'CHANGE cellphone cellphone VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B2A6C7E1D4E64E8 ON supplier (name)');
    }
}
