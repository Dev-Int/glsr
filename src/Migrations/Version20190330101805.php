<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190330101805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gs_material (id INT AUTO_INCREMENT NOT NULL, unit_working_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, multiple TINYINT(1) NOT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_BB6128975E237E06 (name), UNIQUE INDEX UNIQ_BB612897989D9B62 (slug), INDEX IDX_BB61289726A1E4F6 (unit_working_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gs_material_article (material_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_BDAC0F2E308AC6F (material_id), INDEX IDX_BDAC0F27294869C (article_id), PRIMARY KEY(material_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gs_material ADD CONSTRAINT FK_BB61289726A1E4F6 FOREIGN KEY (unit_working_id) REFERENCES app_unit (id)');
        $this->addSql('ALTER TABLE gs_material_article ADD CONSTRAINT FK_BDAC0F2E308AC6F FOREIGN KEY (material_id) REFERENCES gs_material (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gs_material_article ADD CONSTRAINT FK_BDAC0F27294869C FOREIGN KEY (article_id) REFERENCES app_article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gs_material_article DROP FOREIGN KEY FK_BDAC0F2E308AC6F');
        $this->addSql('DROP TABLE gs_material');
        $this->addSql('DROP TABLE gs_material_article');
    }
}
