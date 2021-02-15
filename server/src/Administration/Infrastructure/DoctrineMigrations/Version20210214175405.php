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
            'parent_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', ' .
            '`label` VARCHAR(150) NOT NULL, path VARCHAR(255) NOT NULL, ' .
            'slug VARCHAR(255) NOT NULL, ' .
            'INDEX IDX_494FD646727ACA70 (parent_id), ' .
            'PRIMARY KEY(uuid)' .
            ') DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE family_log ' .
            'ADD CONSTRAINT FK_494FD646727ACA70 FOREIGN KEY (parent_id) ' .
            'REFERENCES family_log (uuid) ON DELETE CASCADE'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE family_log DROP FOREIGN KEY FK_494FD646727ACA70');
        $this->addSql('DROP TABLE family_log');
    }
}
