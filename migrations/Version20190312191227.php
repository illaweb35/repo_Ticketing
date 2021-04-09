<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190312191227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_97A0ADA31A4A96CE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ticket AS SELECT id, resa_id, last_name, first_name, birthday, country, reduce_price, price_ticket, created_at FROM ticket');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('CREATE TABLE ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, resa_id INTEGER DEFAULT NULL, last_name VARCHAR(255) NOT NULL COLLATE BINARY, first_name VARCHAR(255) NOT NULL COLLATE BINARY, birthday DATETIME NOT NULL, country VARCHAR(255) NOT NULL COLLATE BINARY, reduce_price BOOLEAN NOT NULL, price_ticket DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, age_client INTEGER DEFAULT NULL, CONSTRAINT FK_97A0ADA31A4A96CE FOREIGN KEY (resa_id) REFERENCES resa (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ticket (id, resa_id, last_name, first_name, birthday, country, reduce_price, price_ticket, created_at) SELECT id, resa_id, last_name, first_name, birthday, country, reduce_price, price_ticket, created_at FROM __temp__ticket');
        $this->addSql('DROP TABLE __temp__ticket');
        $this->addSql('CREATE INDEX IDX_97A0ADA31A4A96CE ON ticket (resa_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_97A0ADA31A4A96CE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ticket AS SELECT id, resa_id, last_name, first_name, birthday, country, reduce_price, price_ticket, created_at FROM ticket');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('CREATE TABLE ticket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, resa_id INTEGER DEFAULT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, birthday DATETIME NOT NULL, country VARCHAR(255) NOT NULL, reduce_price BOOLEAN NOT NULL, price_ticket DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO ticket (id, resa_id, last_name, first_name, birthday, country, reduce_price, price_ticket, created_at) SELECT id, resa_id, last_name, first_name, birthday, country, reduce_price, price_ticket, created_at FROM __temp__ticket');
        $this->addSql('DROP TABLE __temp__ticket');
        $this->addSql('CREATE INDEX IDX_97A0ADA31A4A96CE ON ticket (resa_id)');
    }
}
