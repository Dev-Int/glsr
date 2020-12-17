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

namespace Infrastructure\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206170233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create company table and Messenger installation.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE company (' .
                'uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ' .
                'name VARCHAR(150) NOT NULL, ' .
                'address VARCHAR(255) NOT NULL, ' .
                'phone VARCHAR(255) NOT NULL, ' .
                'facsimile VARCHAR(255) DEFAULT NULL, ' .
                'email VARCHAR(255) NOT NULL, ' .
                'contact VARCHAR(255) NOT NULL, ' .
                'cellphone VARCHAR(255) NOT NULL, ' .
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
        $this->addSql('DROP TABLE messenger_messages');
    }
}
