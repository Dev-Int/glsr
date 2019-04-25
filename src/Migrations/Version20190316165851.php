<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190316165851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_supplier (id INT AUTO_INCREMENT NOT NULL, family_log_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(5) NOT NULL, town VARCHAR(255) NOT NULL, phone VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', fax VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', mail VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, gsm VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', delaydeliv SMALLINT NOT NULL, orderdate LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', active TINYINT(1) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_93AA0CD3989D9B62 (slug), INDEX IDX_93AA0CD323570A93 (family_log_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_supplier ADD CONSTRAINT FK_93AA0CD323570A93 FOREIGN KEY (family_log_id) REFERENCES app_familylog (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE app_supplier');
    }
}
