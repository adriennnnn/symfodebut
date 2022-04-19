<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414131455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__campaign AS SELECT id, title, content, created_at, updated_at, goal, email FROM campaign');
        $this->addSql('DROP TABLE campaign');
        $this->addSql('CREATE TABLE campaign (id BLOB NOT NULL --(DC2Type:uuid)
        , title VARCHAR(150) DEFAULT \'NULL\', content CLOB DEFAULT \'NULL\', created_at DATETIME DEFAULT \'NULL\', updated_at DATETIME DEFAULT \'NULL\', goal INTEGER DEFAULT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(150) DEFAULT \'NULL\', PRIMARY KEY(id))');
        $this->addSql('INSERT INTO campaign (id, title, content, created_at, updated_at, goal, email) SELECT id, title, content, created_at, updated_at, goal, email FROM __temp__campaign');
        $this->addSql('DROP TABLE __temp__campaign');
        $this->addSql('DROP INDEX fk_participant_campaign1_idx');
        $this->addSql('CREATE TEMPORARY TABLE __temp__participant AS SELECT id, campaign_id, name, email FROM participant');
        $this->addSql('DROP TABLE participant');
        $this->addSql('CREATE TABLE participant (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, campaign_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , name VARCHAR(200) DEFAULT \'NULL\', email VARCHAR(200) DEFAULT \'NULL\', CONSTRAINT FK_D79F6B11F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO participant (id, campaign_id, name, email) SELECT id, campaign_id, name, email FROM __temp__participant');
        $this->addSql('DROP TABLE __temp__participant');
        $this->addSql('CREATE INDEX fk_participant_campaign1_idx ON participant (campaign_id)');
        $this->addSql('DROP INDEX fk_payment_participant1_idx');
        $this->addSql('CREATE TEMPORARY TABLE __temp__payment AS SELECT id, participant_id, amount, created_at, updated_at FROM payment');
        $this->addSql('DROP TABLE payment');
        $this->addSql('CREATE TABLE payment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, participant_id INTEGER DEFAULT NULL, amount INTEGER DEFAULT NULL, created_at DATETIME DEFAULT \'NULL\', updated_at DATETIME DEFAULT \'NULL\', CONSTRAINT FK_6D28840D9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO payment (id, participant_id, amount, created_at, updated_at) SELECT id, participant_id, amount, created_at, updated_at FROM __temp__payment');
        $this->addSql('DROP TABLE __temp__payment');
        $this->addSql('CREATE INDEX fk_payment_participant1_idx ON payment (participant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__campaign AS SELECT id, title, content, created_at, updated_at, goal, email FROM campaign');
        $this->addSql('DROP TABLE campaign');
        $this->addSql('CREATE TABLE campaign (id VARCHAR(32) NOT NULL, title VARCHAR(150) DEFAULT \'NULL\', content CLOB DEFAULT \'NULL\', created_at DATETIME DEFAULT \'NULL\', updated_at DATETIME DEFAULT \'NULL\', goal INTEGER DEFAULT NULL, email VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO campaign (id, title, content, created_at, updated_at, goal, email) SELECT id, title, content, created_at, updated_at, goal, email FROM __temp__campaign');
        $this->addSql('DROP TABLE __temp__campaign');
        $this->addSql('DROP INDEX fk_participant_campaign1_idx');
        $this->addSql('CREATE TEMPORARY TABLE __temp__participant AS SELECT id, campaign_id, name, email FROM participant');
        $this->addSql('DROP TABLE participant');
        $this->addSql('CREATE TABLE participant (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, campaign_id VARCHAR(32) DEFAULT NULL, name VARCHAR(200) DEFAULT \'NULL\', email VARCHAR(200) DEFAULT \'NULL\')');
        $this->addSql('INSERT INTO participant (id, campaign_id, name, email) SELECT id, campaign_id, name, email FROM __temp__participant');
        $this->addSql('DROP TABLE __temp__participant');
        $this->addSql('CREATE INDEX fk_participant_campaign1_idx ON participant (campaign_id)');
        $this->addSql('DROP INDEX fk_payment_participant1_idx');
        $this->addSql('CREATE TEMPORARY TABLE __temp__payment AS SELECT id, participant_id, amount, created_at, updated_at FROM payment');
        $this->addSql('DROP TABLE payment');
        $this->addSql('CREATE TABLE payment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, participant_id INTEGER DEFAULT NULL, amount INTEGER DEFAULT NULL, created_at DATETIME DEFAULT \'NULL\', updated_at DATETIME DEFAULT \'NULL\')');
        $this->addSql('INSERT INTO payment (id, participant_id, amount, created_at, updated_at) SELECT id, participant_id, amount, created_at, updated_at FROM __temp__payment');
        $this->addSql('DROP TABLE __temp__payment');
        $this->addSql('CREATE INDEX fk_payment_participant1_idx ON payment (participant_id)');
    }
}
