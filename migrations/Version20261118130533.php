<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261118130533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__genre AS SELECT id, nom FROM genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO genre (id, nom) SELECT id, nom FROM __temp__genre');
        $this->addSql('DROP TABLE __temp__genre');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_835033F86C6E55B5 ON genre (nom)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__genre AS SELECT id, nom FROM genre');
        $this->addSql('DROP TABLE genre');
        $this->addSql('CREATE TABLE genre (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO genre (id, nom) SELECT id, nom FROM __temp__genre');
        $this->addSql('DROP TABLE __temp__genre');
    }
}
