<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404143000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_asset AS SELECT id, number, data FROM user_asset');
        $this->addSql('DROP TABLE user_asset');
        $this->addSql('CREATE TABLE user_asset (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, asset_id INTEGER NOT NULL, number INTEGER NOT NULL, data VARCHAR(255) NOT NULL, CONSTRAINT FK_E06DA104A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E06DA1045DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_asset (id, number, data) SELECT id, number, data FROM __temp__user_asset');
        $this->addSql('DROP TABLE __temp__user_asset');
        $this->addSql('CREATE INDEX IDX_E06DA104A76ED395 ON user_asset (user_id)');
        $this->addSql('CREATE INDEX IDX_E06DA1045DA1941 ON user_asset (asset_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_asset AS SELECT id, number, data FROM user_asset');
        $this->addSql('DROP TABLE user_asset');
        $this->addSql('CREATE TABLE user_asset (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, number INTEGER NOT NULL, data VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user_asset (id, number, data) SELECT id, number, data FROM __temp__user_asset');
        $this->addSql('DROP TABLE __temp__user_asset');
    }
}
