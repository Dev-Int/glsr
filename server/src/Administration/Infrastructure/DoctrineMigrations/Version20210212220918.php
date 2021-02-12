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
final class Version20210212220918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add supplier table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE supplier (' .
                'uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', ' .
                'name VARCHAR(255) NOT NULL, ' .
                'slug VARCHAR(255) NOT NULL, ' .
                'address VARCHAR(255) NOT NULL, ' .
                'zip_code VARCHAR(5) NOT NULL, ' .
                'town VARCHAR(255) NOT NULL, ' .
                'country VARCHAR(255) NOT NULL, ' .
                'phone VARCHAR(50) NOT NULL, ' .
                'facsimile VARCHAR(50) NOT NULL, ' .
                'email VARCHAR(255) NOT NULL, ' .
                'contact VARCHAR(255) NOT NULL, ' .
                'cellphone VARCHAR(50) NOT NULL, ' .
                'family_log VARCHAR(255) NOT NULL, ' .
                'delay_delivery INT NOT NULL, ' .
                'order_days LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', ' .
                'active TINYINT(1) NOT NULL, ' .
                'UNIQUE INDEX UNIQ_9B2A6C7E5E237E06 (name), ' .
                'UNIQUE INDEX UNIQ_9B2A6C7E989D9B62 (slug), ' .
                'PRIMARY KEY(uuid)' .
            ') DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE supplier');
    }
}
