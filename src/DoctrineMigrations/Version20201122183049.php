<?php

declare(strict_types=1);

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201122183049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_article (id INT AUTO_INCREMENT NOT NULL, supplier_id INT DEFAULT NULL, unit_storage_id INT DEFAULT NULL, unit_working_id INT DEFAULT NULL, tva_id INT DEFAULT NULL, family_log_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, packaging NUMERIC(7, 3) NOT NULL, price NUMERIC(7, 3) NOT NULL, quantity NUMERIC(7, 3) DEFAULT \'0\', minstock NUMERIC(7, 3) NOT NULL, active TINYINT(1) NOT NULL, slug VARCHAR(128) NOT NULL, create_at DATETIME NOT NULL, update_at DATETIME NOT NULL, delete_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_EF678E2B989D9B62 (slug), INDEX IDX_EF678E2B2ADD6D8C (supplier_id), INDEX IDX_EF678E2B5F6D4D50 (unit_storage_id), INDEX IDX_EF678E2B26A1E4F6 (unit_working_id), INDEX IDX_EF678E2B4D79775F (tva_id), INDEX IDX_EF678E2B23570A93 (family_log_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_article_zonestorage (article_id INT NOT NULL, zone_storage_id INT NOT NULL, INDEX IDX_566756677294869C (article_id), INDEX IDX_566756677C24C870 (zone_storage_id), PRIMARY KEY(article_id, zone_storage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(5) NOT NULL, town VARCHAR(255) NOT NULL, phone VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', fax VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', mail VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, gsm VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_familylog (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, path VARCHAR(3000) DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, level INT DEFAULT NULL, UNIQUE INDEX UNIQ_824FA4AA989D9B62 (slug), INDEX IDX_824FA4AA727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_settings (id INT AUTO_INCREMENT NOT NULL, inventory_style VARCHAR(50) NOT NULL, calculation VARCHAR(50) NOT NULL, first_inventory DATETIME DEFAULT NULL, currency VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_supplier (id INT AUTO_INCREMENT NOT NULL, family_log_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zipcode VARCHAR(5) NOT NULL, town VARCHAR(255) NOT NULL, phone VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', fax VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', mail VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, gsm VARCHAR(35) NOT NULL COMMENT \'(DC2Type:phone_number)\', delaydeliv SMALLINT NOT NULL, orderdate LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', active TINYINT(1) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_93AA0CD3989D9B62 (slug), INDEX IDX_93AA0CD323570A93 (family_log_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_tva (id INT AUTO_INCREMENT NOT NULL, rate NUMERIC(4, 3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, abbr VARCHAR(50) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_D99529F3989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_zonestorage (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_CBBFF279989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_article ADD CONSTRAINT FK_EF678E2B2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES app_supplier (id)');
        $this->addSql('ALTER TABLE app_article ADD CONSTRAINT FK_EF678E2B5F6D4D50 FOREIGN KEY (unit_storage_id) REFERENCES app_unit (id)');
        $this->addSql('ALTER TABLE app_article ADD CONSTRAINT FK_EF678E2B26A1E4F6 FOREIGN KEY (unit_working_id) REFERENCES app_unit (id)');
        $this->addSql('ALTER TABLE app_article ADD CONSTRAINT FK_EF678E2B4D79775F FOREIGN KEY (tva_id) REFERENCES app_tva (id)');
        $this->addSql('ALTER TABLE app_article ADD CONSTRAINT FK_EF678E2B23570A93 FOREIGN KEY (family_log_id) REFERENCES app_familylog (id)');
        $this->addSql('ALTER TABLE app_article_zonestorage ADD CONSTRAINT FK_566756677294869C FOREIGN KEY (article_id) REFERENCES app_article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_article_zonestorage ADD CONSTRAINT FK_566756677C24C870 FOREIGN KEY (zone_storage_id) REFERENCES app_zonestorage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_familylog ADD CONSTRAINT FK_824FA4AA727ACA70 FOREIGN KEY (parent_id) REFERENCES app_familylog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_supplier ADD CONSTRAINT FK_93AA0CD323570A93 FOREIGN KEY (family_log_id) REFERENCES app_familylog (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_article_zonestorage DROP FOREIGN KEY FK_566756677294869C');
        $this->addSql('ALTER TABLE app_article DROP FOREIGN KEY FK_EF678E2B23570A93');
        $this->addSql('ALTER TABLE app_familylog DROP FOREIGN KEY FK_824FA4AA727ACA70');
        $this->addSql('ALTER TABLE app_supplier DROP FOREIGN KEY FK_93AA0CD323570A93');
        $this->addSql('ALTER TABLE app_article DROP FOREIGN KEY FK_EF678E2B2ADD6D8C');
        $this->addSql('ALTER TABLE app_article DROP FOREIGN KEY FK_EF678E2B4D79775F');
        $this->addSql('ALTER TABLE app_article DROP FOREIGN KEY FK_EF678E2B5F6D4D50');
        $this->addSql('ALTER TABLE app_article DROP FOREIGN KEY FK_EF678E2B26A1E4F6');
        $this->addSql('ALTER TABLE app_article_zonestorage DROP FOREIGN KEY FK_566756677C24C870');
        $this->addSql('DROP TABLE app_article');
        $this->addSql('DROP TABLE app_article_zonestorage');
        $this->addSql('DROP TABLE app_company');
        $this->addSql('DROP TABLE app_familylog');
        $this->addSql('DROP TABLE app_settings');
        $this->addSql('DROP TABLE app_supplier');
        $this->addSql('DROP TABLE app_tva');
        $this->addSql('DROP TABLE app_unit');
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE app_zonestorage');
    }
}
