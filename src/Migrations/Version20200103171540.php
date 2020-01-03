<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200103171540 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projet ADD credit_garantie NUMERIC(10, 2) NOT NULL, ADD credit_taux NUMERIC(5, 2) NOT NULL, ADD credit_taux_ass NUMERIC(5, 2) NOT NULL, DROP tx_emprunt, DROP tx_emprunt_ass');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE projet ADD tx_emprunt NUMERIC(5, 2) NOT NULL, ADD tx_emprunt_ass NUMERIC(5, 2) NOT NULL, DROP credit_garantie, DROP credit_taux, DROP credit_taux_ass');
    }
}
