<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191103224119 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bien_type (id INT AUTO_INCREMENT NOT NULL, bien_type VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, net_vendeur NUMERIC(12, 2) NOT NULL, frais_agence NUMERIC(10, 2) NOT NULL, frais_notaire NUMERIC(10, 2) NOT NULL, travaux NUMERIC(10, 2) NOT NULL, meubles NUMERIC(10, 2) NOT NULL, apport NUMERIC(10, 2) NOT NULL, credit_frais_dossier NUMERIC(10, 2) NOT NULL, tx_emprunt NUMERIC(5, 2) NOT NULL, tx_emprunt_ass NUMERIC(5, 2) NOT NULL, credit_duree_mois SMALLINT NOT NULL, credit_date_debut DATETIME NOT NULL, loyer_cible_hc NUMERIC(10, 2) NOT NULL, taxe_fonciere NUMERIC(10, 2) NOT NULL, charges_non_recup NUMERIC(10, 2) NOT NULL, cout_assurance_bien NUMERIC(10, 2) NOT NULL, cout_travaux_entretiens NUMERIC(10, 2) NOT NULL, cout_comptable NUMERIC(10, 2) NOT NULL, cout_gestion_locative NUMERIC(10, 2) NOT NULL, cout_autre NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bien ADD an_construction SMALLINT DEFAULT NULL, ADD an_achat SMALLINT DEFAULT NULL, ADD date_mise_vente DATETIME DEFAULT NULL, ADD proprio_nom VARCHAR(50) DEFAULT NULL, ADD proprio_age SMALLINT DEFAULT NULL, ADD vente_motif VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(50) DEFAULT NULL, ADD last_name VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE bien_type');
        $this->addSql('DROP TABLE projet');
        $this->addSql('ALTER TABLE bien DROP an_construction, DROP an_achat, DROP date_mise_vente, DROP proprio_nom, DROP proprio_age, DROP vente_motif');
        $this->addSql('ALTER TABLE user DROP first_name, DROP last_name');
    }
}
