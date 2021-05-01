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

namespace Core\Infrastructure\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201219174027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user table and Messenger installation';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE user (' .
            'uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ' .
            'username VARCHAR(150) NOT NULL, ' .
            'email VARCHAR(255) NOT NULL, ' .
            'password VARCHAR(36) NOT NULL, ' .
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
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
