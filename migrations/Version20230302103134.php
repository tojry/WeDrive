<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302103134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_amis (id INT AUTO_INCREMENT NOT NULL, nom_groupe VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notif_annulation (id INT AUTO_INCREMENT NOT NULL, utilisateur_concerne_id INT NOT NULL, trajet_concerne_id INT NOT NULL, INDEX IDX_54A7AF1790E0F362 (utilisateur_concerne_id), UNIQUE INDEX UNIQ_54A7AF1794168B62 (trajet_concerne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notif_reponse (id INT AUTO_INCREMENT NOT NULL, reponse_id INT NOT NULL, utilisateur_concerne_id INT NOT NULL, UNIQUE INDEX UNIQ_A30B7523CF18BB82 (reponse_id), INDEX IDX_A30B752390E0F362 (utilisateur_concerne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notif_trajet_prive (id INT AUTO_INCREMENT NOT NULL, trajet_concerne_id INT NOT NULL, utilisateur_concerne_id INT NOT NULL, UNIQUE INDEX UNIQ_79A51C5E94168B62 (trajet_concerne_id), INDEX IDX_79A51C5E90E0F362 (utilisateur_concerne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE point_intermediare (id INT AUTO_INCREMENT NOT NULL, trajet_id INT NOT NULL, ville_id INT NOT NULL, INDEX IDX_CC205634D12A823 (trajet_id), INDEX IDX_CC205634A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, utilisateur_concerne_id INT NOT NULL, trajet_concerne_id INT NOT NULL, texte_reponse VARCHAR(1024) DEFAULT NULL, date_heure_reponse DATE NOT NULL, etat_reponse VARCHAR(20) NOT NULL, INDEX IDX_5FB6DEC790E0F362 (utilisateur_concerne_id), INDEX IDX_5FB6DEC794168B62 (trajet_concerne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, covoitureur_id INT NOT NULL, groupe_ami_id INT DEFAULT NULL, lieu_depart VARCHAR(500) NOT NULL, lieu_arrive VARCHAR(500) NOT NULL, date_heure_depart DATETIME NOT NULL, prix INT NOT NULL, capacite_max INT NOT NULL, precision_lieu_rdv VARCHAR(1024) NOT NULL, commentaire VARCHAR(1024) NOT NULL, INDEX IDX_2B5BA98C2E18FC42 (covoitureur_id), INDEX IDX_2B5BA98CA7D89631 (groupe_ami_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id_offre INT NOT NULL, id_utilisateur INT NOT NULL, INDEX IDX_AB55E24F4103C75F (id_offre), INDEX IDX_AB55E24F50EAE44 (id_utilisateur), PRIMARY KEY(id_offre, id_utilisateur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, adresse_mail VARCHAR(320) NOT NULL, mdp VARCHAR(128) NOT NULL, nom VARCHAR(64) NOT NULL, prenom VARCHAR(64) NOT NULL, sexe VARCHAR(1) NOT NULL, voiture TINYINT(1) NOT NULL, no_tel VARCHAR(11) NOT NULL, mail_notif TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3A1207B9E (adresse_mail), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amitie (utilisateur_id INT NOT NULL, groupe_amis_id INT NOT NULL, INDEX IDX_8FF9F39CFB88E14F (utilisateur_id), INDEX IDX_8FF9F39CB6086589 (groupe_amis_id), PRIMARY KEY(utilisateur_id, groupe_amis_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, ville VARCHAR(500) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE notif_annulation ADD CONSTRAINT FK_54A7AF1790E0F362 FOREIGN KEY (utilisateur_concerne_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE notif_annulation ADD CONSTRAINT FK_54A7AF1794168B62 FOREIGN KEY (trajet_concerne_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE notif_reponse ADD CONSTRAINT FK_A30B7523CF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponse (id)');
        $this->addSql('ALTER TABLE notif_reponse ADD CONSTRAINT FK_A30B752390E0F362 FOREIGN KEY (utilisateur_concerne_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE notif_trajet_prive ADD CONSTRAINT FK_79A51C5E94168B62 FOREIGN KEY (trajet_concerne_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE notif_trajet_prive ADD CONSTRAINT FK_79A51C5E90E0F362 FOREIGN KEY (utilisateur_concerne_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE point_intermediare ADD CONSTRAINT FK_CC205634D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE point_intermediare ADD CONSTRAINT FK_CC205634A73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC790E0F362 FOREIGN KEY (utilisateur_concerne_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC794168B62 FOREIGN KEY (trajet_concerne_id) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C2E18FC42 FOREIGN KEY (covoitureur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CA7D89631 FOREIGN KEY (groupe_ami_id) REFERENCES groupe_amis (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F4103C75F FOREIGN KEY (id_offre) REFERENCES trajet (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE amitie ADD CONSTRAINT FK_8FF9F39CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amitie ADD CONSTRAINT FK_8FF9F39CB6086589 FOREIGN KEY (groupe_amis_id) REFERENCES groupe_amis (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notif_annulation DROP FOREIGN KEY FK_54A7AF1790E0F362');
        $this->addSql('ALTER TABLE notif_annulation DROP FOREIGN KEY FK_54A7AF1794168B62');
        $this->addSql('ALTER TABLE notif_reponse DROP FOREIGN KEY FK_A30B7523CF18BB82');
        $this->addSql('ALTER TABLE notif_reponse DROP FOREIGN KEY FK_A30B752390E0F362');
        $this->addSql('ALTER TABLE notif_trajet_prive DROP FOREIGN KEY FK_79A51C5E94168B62');
        $this->addSql('ALTER TABLE notif_trajet_prive DROP FOREIGN KEY FK_79A51C5E90E0F362');
        $this->addSql('ALTER TABLE point_intermediare DROP FOREIGN KEY FK_CC205634D12A823');
        $this->addSql('ALTER TABLE point_intermediare DROP FOREIGN KEY FK_CC205634A73F0036');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC790E0F362');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC794168B62');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C2E18FC42');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CA7D89631');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F4103C75F');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F50EAE44');
        $this->addSql('ALTER TABLE amitie DROP FOREIGN KEY FK_8FF9F39CFB88E14F');
        $this->addSql('ALTER TABLE amitie DROP FOREIGN KEY FK_8FF9F39CB6086589');
        $this->addSql('DROP TABLE groupe_amis');
        $this->addSql('DROP TABLE notif_annulation');
        $this->addSql('DROP TABLE notif_reponse');
        $this->addSql('DROP TABLE notif_trajet_prive');
        $this->addSql('DROP TABLE point_intermediare');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE amitie');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
