<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250417143107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE asset (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE platform (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, end_point VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE portfolio (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, parent_id INTEGER DEFAULT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, CONSTRAINT FK_A9ED1062727ACA70 FOREIGN KEY (parent_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A9ED1062A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A9ED1062727ACA70 ON portfolio (parent_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A9ED1062A76ED395 ON portfolio (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE portfolio_asset (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portfolio_id INTEGER NOT NULL, asset_id INTEGER NOT NULL, CONSTRAINT FK_5FF77019B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5FF770195DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5FF77019B96B5643 ON portfolio_asset (portfolio_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5FF770195DA1941 ON portfolio_asset (asset_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transactions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, asset_id INTEGER NOT NULL, quantity INTEGER NOT NULL, price INTEGER NOT NULL, CONSTRAINT FK_EAA81A4CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EAA81A4C5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EAA81A4CA76ED395 ON transactions (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EAA81A4C5DA1941 ON transactions (asset_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
            , password VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_platform (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, platform_id INTEGER NOT NULL, api_key VARCHAR(255) NOT NULL, CONSTRAINT FK_D9DF34CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D9DF34CBFFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D9DF34CBA76ED395 ON user_platform (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D9DF34CBFFE6496F ON user_platform (platform_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
            , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
            )
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE asset
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE platform
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE portfolio
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE portfolio_asset
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transactions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_platform
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
