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
final class Version20210214175405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add family_log table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE family_log (' .
            'uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ' .
            'name VARCHAR(150) NOT NULL, ' .
            'parent VARCHAR(255) DEFAULT NULL, ' .
            'path VARCHAR(255) NOT NULL, ' .
            'slug VARCHAR(255) NOT NULL, PRIMARY KEY(uuid)' .
            ') DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE family_log');
    }
}
