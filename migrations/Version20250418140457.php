<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250418140457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE asset ADD COLUMN symbol VARCHAR(10) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE asset ADD COLUMN current_value DOUBLE PRECISION DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__asset AS SELECT id, name FROM asset
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE asset
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE asset (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO asset (id, name) SELECT id, name FROM __temp__asset
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__asset
        SQL);
    }
}
