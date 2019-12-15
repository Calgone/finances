<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191215204835 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bien ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE lot ADD bien_id INT NOT NULL, ADD chauffage_type SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BBD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('CREATE INDEX IDX_B81291BBD95B80F ON lot (bien_id)');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL, ADD birth_date DATE DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bien DROP created_at');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BBD95B80F');
        $this->addSql('DROP INDEX IDX_B81291BBD95B80F ON lot');
        $this->addSql('ALTER TABLE lot DROP bien_id, DROP chauffage_type');
        $this->addSql('ALTER TABLE user DROP created_at, DROP birth_date');
    }
}
