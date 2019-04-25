<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190316135804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(40) NOT NULL, salt VARCHAR(32) DEFAULT NULL, enabled TINYINT(1) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_admin TINYINT(1) NOT NULL, is_assistant TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_88BDF3E9F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci, roles LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', password VARCHAR(40) NOT NULL COLLATE utf8mb4_unicode_ci, salt VARCHAR(32) DEFAULT NULL COLLATE utf8mb4_unicode_ci, enabled TINYINT(1) NOT NULL, is_admin TINYINT(1) NOT NULL, is_assistant TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE app_user');
    }
}
