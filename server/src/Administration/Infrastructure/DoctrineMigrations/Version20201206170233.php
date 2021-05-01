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

final class Version20201206170233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create company table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE company (' .
                'uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ' .
                'name VARCHAR(150) NOT NULL, ' .
                'address VARCHAR(255) NOT NULL, ' .
                'zip_code VARCHAR(255) NOT NULL, ' .
                'town VARCHAR(255) NOT NULL, ' .
                'country VARCHAR(255) NOT NULL, ' .
                'phone VARCHAR(255) NOT NULL, ' .
                'facsimile VARCHAR(255) DEFAULT NULL, ' .
                'email VARCHAR(255) NOT NULL, ' .
                'contact VARCHAR(255) NOT NULL, ' .
                'cellphone VARCHAR(255) NOT NULL, ' .
                'PRIMARY KEY(uuid)' .
            ') DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE company');
    }
}
