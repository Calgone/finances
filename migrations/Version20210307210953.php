<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307210953 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE action ADD cree_le DATETIME NOT NULL, ADD maj_le DATETIME DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_47CC8C922FE82D2D ON action (isin)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_47CC8C922FE82D2D ON action');
        $this->addSql('ALTER TABLE action DROP cree_le, DROP maj_le');
    }
}
