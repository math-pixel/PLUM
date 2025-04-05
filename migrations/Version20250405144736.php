<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250405144736 extends AbstractMigration
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
            CREATE TABLE portfolio (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE portfolio_asset (portfolio_id INTEGER NOT NULL, asset_id INTEGER NOT NULL, PRIMARY KEY(portfolio_id, asset_id), CONSTRAINT FK_5FF77019B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5FF770195DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5FF77019B96B5643 ON portfolio_asset (portfolio_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5FF770195DA1941 ON portfolio_asset (asset_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE portfolio_portfolio (portfolio_source INTEGER NOT NULL, portfolio_target INTEGER NOT NULL, PRIMARY KEY(portfolio_source, portfolio_target), CONSTRAINT FK_5745814E59619246 FOREIGN KEY (portfolio_source) REFERENCES portfolio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5745814E4084C2C9 FOREIGN KEY (portfolio_target) REFERENCES portfolio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5745814E59619246 ON portfolio_portfolio (portfolio_source)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5745814E4084C2C9 ON portfolio_portfolio (portfolio_target)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_asset (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, number INTEGER NOT NULL, data VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_platform (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, api_key VARCHAR(255) NOT NULL)
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
            DROP TABLE portfolio_portfolio
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_asset
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_platform
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
