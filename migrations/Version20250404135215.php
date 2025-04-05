<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404135215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asset (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE platform (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, end_point VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE portfolio (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE portfolio_asset (portfolio_id INTEGER NOT NULL, asset_id INTEGER NOT NULL, PRIMARY KEY(portfolio_id, asset_id), CONSTRAINT FK_5FF77019B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5FF770195DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5FF77019B96B5643 ON portfolio_asset (portfolio_id)');
        $this->addSql('CREATE INDEX IDX_5FF770195DA1941 ON portfolio_asset (asset_id)');
        $this->addSql('CREATE TABLE portfolio_portfolio (portfolio_source INTEGER NOT NULL, portfolio_target INTEGER NOT NULL, PRIMARY KEY(portfolio_source, portfolio_target), CONSTRAINT FK_5745814E59619246 FOREIGN KEY (portfolio_source) REFERENCES portfolio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5745814E4084C2C9 FOREIGN KEY (portfolio_target) REFERENCES portfolio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5745814E59619246 ON portfolio_portfolio (portfolio_source)');
        $this->addSql('CREATE INDEX IDX_5745814E4084C2C9 ON portfolio_portfolio (portfolio_target)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
        $this->addSql('CREATE TABLE user_asset (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, number INTEGER NOT NULL, data VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE user_platform (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, api_key VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE asset');
        $this->addSql('DROP TABLE platform');
        $this->addSql('DROP TABLE portfolio');
        $this->addSql('DROP TABLE portfolio_asset');
        $this->addSql('DROP TABLE portfolio_portfolio');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_asset');
        $this->addSql('DROP TABLE user_platform');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
