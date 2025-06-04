<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603093321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE "unique"
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__food AS SELECT id, icon, name, healing_value FROM food
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE food
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE food (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, icon VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, healing_value INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO food (id, icon, name, healing_value) SELECT id, icon, name, healing_value FROM __temp__food
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__food
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_D43829F75E237E06 ON food (name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__tool AS SELECT id, name, icon FROM tool
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tool
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tool (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO tool (id, name, icon) SELECT id, name, icon FROM __temp__tool
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__tool
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_20F33ED15E237E06 ON tool (name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__weapon AS SELECT id, name, icon, dmg FROM weapon
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE weapon
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE weapon (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, dmg INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO weapon (id, name, icon, dmg) SELECT id, name, icon, dmg FROM __temp__weapon
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__weapon
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_6933A7E65E237E06 ON weapon (name)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE "unique" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__food AS SELECT id, icon, name, healing_value FROM food
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE food
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE food (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, icon VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, healing_value INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO food (id, icon, name, healing_value) SELECT id, icon, name, healing_value FROM __temp__food
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__food
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__tool AS SELECT id, name, icon FROM tool
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tool
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tool (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO tool (id, name, icon) SELECT id, name, icon FROM __temp__tool
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__tool
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__weapon AS SELECT id, name, icon, dmg FROM weapon
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE weapon
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE weapon (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, dmg INTEGER NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO weapon (id, name, icon, dmg) SELECT id, name, icon, dmg FROM __temp__weapon
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__weapon
        SQL);
    }
}
