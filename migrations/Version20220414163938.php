<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414163938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces_history (id_history INT AUTO_INCREMENT NOT NULL, id_annonce INT UNSIGNED DEFAULT NULL, id_annonce_owner INT UNSIGNED DEFAULT NULL, INDEX annonce_id_idx (id_annonce), INDEX owner_id_idx (id_annonce_owner), PRIMARY KEY(id_history)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, id_domaine INT DEFAULT NULL, id_owner INT UNSIGNED DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type VARCHAR(255) NOT NULL, INDEX id_domaine_idx (id_domaine), INDEX id_owner_index (id_owner), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id_message INT AUTO_INCREMENT NOT NULL, id_sender INT UNSIGNED DEFAULT NULL, id_recipient INT UNSIGNED DEFAULT NULL, message VARCHAR(500) NOT NULL, date DATETIME NOT NULL, is_read INT NOT NULL, INDEX user_id2_idx (id_recipient), INDEX user_id_idx (id_sender), PRIMARY KEY(id_message)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id_skill INT UNSIGNED AUTO_INCREMENT NOT NULL, category VARCHAR(45) NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(500) NOT NULL, PRIMARY KEY(id_skill)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skills_list (id_user INT UNSIGNED NOT NULL, id_skill INT UNSIGNED NOT NULL, INDEX IDX_4CABDE726B3CA4B (id_user), INDEX IDX_4CABDE72B0B8A547 (id_skill), PRIMARY KEY(id_user, id_skill)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces_history ADD CONSTRAINT FK_7A7FEE4328C83A95 FOREIGN KEY (id_annonce) REFERENCES annonce (id_annonce)');
        $this->addSql('ALTER TABLE annonces_history ADD CONSTRAINT FK_7A7FEE4366C5FC86 FOREIGN KEY (id_annonce_owner) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687FA632A3BC FOREIGN KEY (id_domaine) REFERENCES domaine (id)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F21E5A74C FOREIGN KEY (id_owner) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F7937FF22 FOREIGN KEY (id_sender) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE831476E FOREIGN KEY (id_recipient) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE skills_list ADD CONSTRAINT FK_4CABDE726B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE skills_list ADD CONSTRAINT FK_4CABDE72B0B8A547 FOREIGN KEY (id_skill) REFERENCES skill (id_skill)');
        $this->addSql('ALTER TABLE annonce CHANGE id_owner id_owner INT UNSIGNED DEFAULT NULL, CHANGE type type VARCHAR(45) NOT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL, CHANGE domaine domaine VARCHAR(45) NOT NULL');
        $this->addSql('ALTER TABLE domaine CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE messages CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE message message LONGTEXT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE is_read is_read TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE id_request id_request INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(45) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skills_list DROP FOREIGN KEY FK_4CABDE72B0B8A547');
        $this->addSql('DROP TABLE annonces_history');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE skills_list');
        $this->addSql('ALTER TABLE annonce CHANGE id_owner id_owner INT UNSIGNED NOT NULL, CHANGE type type VARCHAR(45) DEFAULT \'1\' NOT NULL, CHANGE domaine domaine VARCHAR(25) DEFAULT NULL, CHANGE status status VARCHAR(25) DEFAULT \'1\' NOT NULL, CHANGE location location VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE domaine CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE messages CHANGE title title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE message message LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE is_read is_read TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE id_request id_request INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(4500) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
