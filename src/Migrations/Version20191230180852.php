<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191230180852 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projet ADD bien_id INT NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9BD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9BD95B80F ON projet (bien_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9BD95B80F');
        $this->addSql('DROP INDEX IDX_50159CA9BD95B80F ON projet');
        $this->addSql('ALTER TABLE projet DROP bien_id, DROP created_at');
    }
}
