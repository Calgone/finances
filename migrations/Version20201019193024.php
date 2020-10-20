<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201019193024 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, isin VARCHAR(12) NOT NULL, ticker VARCHAR(12) NOT NULL, logo VARCHAR(255) DEFAULT NULL, ipo DATE NOT NULL, capitalisation NUMERIC(18, 4) NOT NULL, actions_en_circulation INT NOT NULL, web_url VARCHAR(255) DEFAULT NULL, tel VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(100) NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE alerte (id INT AUTO_INCREMENT NOT NULL, cree_le DATETIME NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, pays VARCHAR(100) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, cp VARCHAR(5) DEFAULT NULL, ville VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bien (id INT AUTO_INCREMENT NOT NULL, bien_type SMALLINT NOT NULL, adresse VARCHAR(255) NOT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(100) NOT NULL, an_construction SMALLINT DEFAULT NULL, an_achat SMALLINT DEFAULT NULL, date_mise_vente DATETIME DEFAULT NULL, proprio_nom VARCHAR(50) DEFAULT NULL, proprio_age SMALLINT DEFAULT NULL, vente_motif VARCHAR(255) DEFAULT NULL, cree_le DATETIME NOT NULL, vendu_le DATE DEFAULT NULL, prix_net_vendeur NUMERIC(12, 2) DEFAULT NULL, frais_agence NUMERIC(12, 2) DEFAULT NULL, titre VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, banque_id INT NOT NULL, numero VARCHAR(255) NOT NULL, cree_le DATETIME NOT NULL, ouvert_le DATE NOT NULL, ferme_le DATE DEFAULT NULL, solde NUMERIC(19, 4) NOT NULL, INDEX IDX_CFF6526037E080D9 (banque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cote (id INT AUTO_INCREMENT NOT NULL, action_id INT NOT NULL, prix NUMERIC(19, 4) NOT NULL, prix_ouverture NUMERIC(19, 4) NOT NULL, prix_max NUMERIC(19, 4) NOT NULL, prix_min NUMERIC(19, 4) NOT NULL, prix_cloture_veille NUMERIC(19, 4) NOT NULL, cree_le DATETIME NOT NULL, INDEX IDX_3DD722C99D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lot (id INT AUTO_INCREMENT NOT NULL, bien_id INT NOT NULL, surface SMALLINT NOT NULL, lot_type SMALLINT NOT NULL, chauffage_type SMALLINT NOT NULL, INDEX IDX_B81291BBD95B80F (bien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marche (id INT AUTO_INCREMENT NOT NULL, pays VARCHAR(100) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, type SMALLINT NOT NULL, `label` VARCHAR(255) NOT NULL, montant NUMERIC(12, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `ordre` (id INT AUTO_INCREMENT NOT NULL, action_id INT NOT NULL, date DATETIME NOT NULL, `label` VARCHAR(255) NOT NULL, isin VARCHAR(20) NOT NULL, etat VARCHAR(50) NOT NULL, quantite INT NOT NULL, type VARCHAR(255) NOT NULL, cours DOUBLE PRECISION NOT NULL, validite DATE NOT NULL, marche VARCHAR(255) NOT NULL, frais_courtage DOUBLE PRECISION NOT NULL, INDEX IDX_737992C99D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, action_id INT NOT NULL, cree_le DATETIME NOT NULL, quantite INT NOT NULL, pru NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_462CE4F59D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, bien_id INT NOT NULL, prix_net_vendeur NUMERIC(12, 2) NOT NULL, frais_agence NUMERIC(10, 2) NOT NULL, frais_notaire NUMERIC(10, 2) NOT NULL, travaux NUMERIC(10, 2) NOT NULL, meubles NUMERIC(10, 2) NOT NULL, apport NUMERIC(10, 2) NOT NULL, credit_frais_dossier NUMERIC(10, 2) NOT NULL, credit_garantie NUMERIC(10, 2) NOT NULL, credit_taux NUMERIC(5, 2) NOT NULL, credit_taux_assurance NUMERIC(5, 2) NOT NULL, credit_duree_mois SMALLINT NOT NULL, credit_date_debut DATETIME NOT NULL, loyer_cible_hc NUMERIC(10, 2) NOT NULL, taxe_fonciere NUMERIC(10, 2) NOT NULL, charge_non_recuperable NUMERIC(10, 2) NOT NULL, cout_assurance_bien NUMERIC(10, 2) NOT NULL, cout_travaux_entretien NUMERIC(10, 2) NOT NULL, cout_comptable NUMERIC(10, 2) NOT NULL, cout_gestion_locative NUMERIC(10, 2) NOT NULL, cout_autre NUMERIC(10, 2) NOT NULL, cree_le DATETIME NOT NULL, INDEX IDX_50159CA9BD95B80F (bien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, last_name VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL, birth_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526037E080D9 FOREIGN KEY (banque_id) REFERENCES banque (id)');
        $this->addSql('ALTER TABLE cote ADD CONSTRAINT FK_3DD722C99D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BBD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('ALTER TABLE `ordre` ADD CONSTRAINT FK_737992C99D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F59D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9BD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cote DROP FOREIGN KEY FK_3DD722C99D32F035');
        $this->addSql('ALTER TABLE `ordre` DROP FOREIGN KEY FK_737992C99D32F035');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F59D32F035');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526037E080D9');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BBD95B80F');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9BD95B80F');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE alerte');
        $this->addSql('DROP TABLE banque');
        $this->addSql('DROP TABLE bien');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE cote');
        $this->addSql('DROP TABLE lot');
        $this->addSql('DROP TABLE marche');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE `ordre`');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE user');
    }
}
