<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420114649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city ADD department_id INT NOT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('CREATE INDEX IDX_2D5B0234AE80F5DF ON city (department_id)');
        $this->addSql('ALTER TABLE department ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_CD1DE18A98260155 ON department (region_id)');
        $this->addSql('ALTER TABLE post ADD city_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D8BAC62AF ON post (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234AE80F5DF');
        $this->addSql('DROP INDEX IDX_2D5B0234AE80F5DF ON city');
        $this->addSql('ALTER TABLE city DROP department_id');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A98260155');
        $this->addSql('DROP INDEX IDX_CD1DE18A98260155 ON department');
        $this->addSql('ALTER TABLE department DROP region_id');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D8BAC62AF');
        $this->addSql('DROP INDEX IDX_5A8A6C8D8BAC62AF ON post');
        $this->addSql('ALTER TABLE post DROP city_id');
    }
}
