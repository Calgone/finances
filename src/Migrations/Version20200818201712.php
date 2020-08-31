<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818201712 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, bank_id INT NOT NULL, number VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, opened_at DATE NOT NULL, closed_at DATE DEFAULT NULL, balance NUMERIC(19, 4) NOT NULL, INDEX IDX_7D3656A411C8FB41 (bank_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(100) NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bank (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(100) NOT NULL, address VARCHAR(255) DEFAULT NULL, cp VARCHAR(5) DEFAULT NULL, city VARCHAR(200) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bien (id INT AUTO_INCREMENT NOT NULL, bien_type SMALLINT NOT NULL, adresse VARCHAR(255) NOT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(100) NOT NULL, an_construction SMALLINT DEFAULT NULL, an_achat SMALLINT DEFAULT NULL, date_mise_vente DATETIME DEFAULT NULL, proprio_nom VARCHAR(50) DEFAULT NULL, proprio_age SMALLINT DEFAULT NULL, vente_motif VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, vendu_le DATE DEFAULT NULL, prix_net_vendeur NUMERIC(12, 2) DEFAULT NULL, frais_agence NUMERIC(12, 2) DEFAULT NULL, titre VARCHAR(100) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exchange (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(100) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lot (id INT AUTO_INCREMENT NOT NULL, bien_id INT NOT NULL, surface SMALLINT NOT NULL, lot_type SMALLINT NOT NULL, chauffage_type SMALLINT NOT NULL, INDEX IDX_B81291BBD95B80F (bien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, type SMALLINT NOT NULL, mean SMALLINT NOT NULL, `label` VARCHAR(255) NOT NULL, montant NUMERIC(12, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, stock_id INT NOT NULL, date DATETIME NOT NULL, `label` VARCHAR(255) NOT NULL, isin VARCHAR(20) NOT NULL, direction VARCHAR(5) NOT NULL, state VARCHAR(50) NOT NULL, volume INT NOT NULL, type VARCHAR(255) NOT NULL, quotation DOUBLE PRECISION NOT NULL, validity DATE NOT NULL, exchange VARCHAR(255) NOT NULL, broker_fee DOUBLE PRECISION NOT NULL, INDEX IDX_F5299398DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE position (id INT AUTO_INCREMENT NOT NULL, stock_id INT NOT NULL, created_at DATETIME NOT NULL, volume INT NOT NULL, unit_cost NUMERIC(10, 2) NOT NULL, UNIQUE INDEX UNIQ_462CE4F5DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, bien_id INT NOT NULL, net_vendeur NUMERIC(12, 2) NOT NULL, frais_agence NUMERIC(10, 2) NOT NULL, frais_notaire NUMERIC(10, 2) NOT NULL, travaux NUMERIC(10, 2) NOT NULL, meubles NUMERIC(10, 2) NOT NULL, apport NUMERIC(10, 2) NOT NULL, credit_frais_dossier NUMERIC(10, 2) NOT NULL, credit_garantie NUMERIC(10, 2) NOT NULL, credit_taux NUMERIC(5, 2) NOT NULL, credit_taux_ass NUMERIC(5, 2) NOT NULL, credit_duree_mois SMALLINT NOT NULL, credit_date_debut DATETIME NOT NULL, loyer_cible_hc NUMERIC(10, 2) NOT NULL, taxe_fonciere NUMERIC(10, 2) NOT NULL, charges_non_recup NUMERIC(10, 2) NOT NULL, cout_assurance_bien NUMERIC(10, 2) NOT NULL, cout_travaux_entretiens NUMERIC(10, 2) NOT NULL, cout_comptable NUMERIC(10, 2) NOT NULL, cout_gestion_locative NUMERIC(10, 2) NOT NULL, cout_autre NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_50159CA9BD95B80F (bien_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quote (id INT AUTO_INCREMENT NOT NULL, stock_id INT NOT NULL, current_price NUMERIC(19, 4) NOT NULL, open_price NUMERIC(19, 4) NOT NULL, high_price NUMERIC(19, 4) NOT NULL, low_price NUMERIC(19, 4) NOT NULL, previous_close_price NUMERIC(19, 4) NOT NULL, price_at DATETIME NOT NULL, INDEX IDX_6B71CBF4DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, isin VARCHAR(12) NOT NULL, ticker VARCHAR(12) NOT NULL, logo VARCHAR(255) DEFAULT NULL, ipo DATE NOT NULL, market_cap NUMERIC(18, 4) NOT NULL, share_outstanding INT NOT NULL, web_url VARCHAR(255) DEFAULT NULL, tel VARCHAR(20) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(50) DEFAULT NULL, last_name VARCHAR(50) DEFAULT NULL, created_at DATETIME NOT NULL, birth_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A411C8FB41 FOREIGN KEY (bank_id) REFERENCES bank (id)');
        $this->addSql('ALTER TABLE lot ADD CONSTRAINT FK_B81291BBD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE position ADD CONSTRAINT FK_462CE4F5DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9BD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id)');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF4DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A411C8FB41');
        $this->addSql('ALTER TABLE lot DROP FOREIGN KEY FK_B81291BBD95B80F');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9BD95B80F');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398DCD6110');
        $this->addSql('ALTER TABLE position DROP FOREIGN KEY FK_462CE4F5DCD6110');
        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF4DCD6110');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE bank');
        $this->addSql('DROP TABLE bien');
        $this->addSql('DROP TABLE exchange');
        $this->addSql('DROP TABLE lot');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE position');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE quote');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE user');
    }
}
