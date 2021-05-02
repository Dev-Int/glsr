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

namespace Core\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210502131525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the first throw of necessary tables.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE company (' .
            'uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ' .
            'company_name VARCHAR(255) NOT NULL, ' .
            'address VARCHAR(255) NOT NULL, ' .
            'zip_code VARCHAR(5) NOT NULL, ' .
            'town VARCHAR(255) NOT NULL, ' .
            'country VARCHAR(255) NOT NULL, ' .
            'phone VARCHAR(14) NOT NULL, ' .
            'facsimile VARCHAR(14) DEFAULT NULL, ' .
            'email VARCHAR(255) NOT NULL, ' .
            'contact_name VARCHAR(255) NOT NULL, ' .
            'cellphone VARCHAR(14) NOT NULL, ' .
            'slug VARCHAR(255) NOT NULL, ' .
            'UNIQUE INDEX UNIQ_4FBF094F1D4E64E8 (company_name), ' .
            'UNIQUE INDEX UNIQ_4FBF094F989D9B62 (slug), ' .
            'PRIMARY KEY(uuid)' .
            ') DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE settings (' .
            'uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ' .
            'locale VARCHAR(255) NOT NULL, ' .
            'currency VARCHAR(255) NOT NULL, ' .
            'PRIMARY KEY(uuid)' .
            ') DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE supplier (' .
            'uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ' .
            'family_log VARCHAR(255) NOT NULL, ' .
            'delay_delivery INT NOT NULL, ' .
            'order_days LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ' .
            'active TINYINT(1) NOT NULL, ' .
            'company_name VARCHAR(255) NOT NULL, ' .
            'address VARCHAR(255) NOT NULL, ' .
            'zip_code VARCHAR(5) NOT NULL, ' .
            'town VARCHAR(255) NOT NULL, ' .
            'country VARCHAR(255) NOT NULL, ' .
            'phone VARCHAR(14) NOT NULL, ' .
            'facsimile VARCHAR(14) DEFAULT NULL, ' .
            'email VARCHAR(255) NOT NULL, ' .
            'contact_name VARCHAR(255) NOT NULL, ' .
            'cellphone VARCHAR(14) NOT NULL, s' .
            'lug VARCHAR(255) NOT NULL, ' .
            'UNIQUE INDEX UNIQ_9B2A6C7E1D4E64E8 (company_name), ' .
            'UNIQUE INDEX UNIQ_9B2A6C7E989D9B62 (slug), ' .
            'PRIMARY KEY(uuid)' .
            ') DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE user (' .
            'uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ' .
            'username VARCHAR(150) NOT NULL, ' .
            'email VARCHAR(255) NOT NULL, ' .
            'password VARCHAR(120) NOT NULL, ' .
            'roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ' .
            'PRIMARY KEY(uuid)' .
            ') DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE messenger_messages (' .
            'id BIGINT AUTO_INCREMENT NOT NULL, ' .
            'body LONGTEXT NOT NULL, ' .
            'headers LONGTEXT NOT NULL, ' .
            'queue_name VARCHAR(190) NOT NULL, ' .
            'created_at DATETIME NOT NULL, ' .
            'available_at DATETIME NOT NULL, ' .
            'delivered_at DATETIME DEFAULT NULL, ' .
            'INDEX IDX_75EA56E0FB7336F0 (queue_name), ' .
            'INDEX IDX_75EA56E0E3BD61CE (available_at), ' .
            'INDEX IDX_75EA56E016BA31DB (delivered_at), ' .
            'PRIMARY KEY(id)' .
            ') DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE supplier');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
