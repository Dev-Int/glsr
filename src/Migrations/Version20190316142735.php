<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190316142735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_tva (id INT AUTO_INCREMENT NOT NULL, rate NUMERIC(4, 3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_zonestorage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_CBBFF279989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, abbr VARCHAR(50) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_D99529F3989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_familylog (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, path VARCHAR(3000) DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, level INT DEFAULT NULL, UNIQUE INDEX UNIQ_824FA4AA989D9B62 (slug), INDEX IDX_824FA4AA727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_familylog ADD CONSTRAINT FK_824FA4AA727ACA70 FOREIGN KEY (parent_id) REFERENCES app_familylog (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_familylog DROP FOREIGN KEY FK_824FA4AA727ACA70');
        $this->addSql('DROP TABLE app_tva');
        $this->addSql('DROP TABLE app_zonestorage');
        $this->addSql('DROP TABLE app_unit');
        $this->addSql('DROP TABLE app_familylog');
    }
}
