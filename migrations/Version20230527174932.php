<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527174932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__outcome AS SELECT id, result FROM outcome');
        $this->addSql('DROP TABLE outcome');
        $this->addSql('CREATE TABLE outcome (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, result VARCHAR(255) NOT NULL, CONSTRAINT FK_30BC6DC2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO outcome (id, result) SELECT id, result FROM __temp__outcome');
        $this->addSql('DROP TABLE __temp__outcome');
        $this->addSql('CREATE INDEX IDX_30BC6DC2A76ED395 ON outcome (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__outcome AS SELECT id, result FROM outcome');
        $this->addSql('DROP TABLE outcome');
        $this->addSql('CREATE TABLE outcome (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, result VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO outcome (id, result) SELECT id, result FROM __temp__outcome');
        $this->addSql('DROP TABLE __temp__outcome');
    }
}
