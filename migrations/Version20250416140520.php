<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416140520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__portfolio_asset AS SELECT portfolio_id, asset_id FROM portfolio_asset
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE portfolio_asset
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE portfolio_asset (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, portfolio_id INTEGER NOT NULL, asset_id INTEGER NOT NULL, CONSTRAINT FK_5FF77019B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5FF770195DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO portfolio_asset (portfolio_id, asset_id) SELECT portfolio_id, asset_id FROM __temp__portfolio_asset
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__portfolio_asset
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5FF770195DA1941 ON portfolio_asset (asset_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5FF77019B96B5643 ON portfolio_asset (portfolio_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__portfolio_asset AS SELECT portfolio_id, asset_id FROM portfolio_asset
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE portfolio_asset
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE portfolio_asset (portfolio_id INTEGER NOT NULL, asset_id INTEGER NOT NULL, PRIMARY KEY(portfolio_id, asset_id), CONSTRAINT FK_5FF77019B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5FF770195DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO portfolio_asset (portfolio_id, asset_id) SELECT portfolio_id, asset_id FROM __temp__portfolio_asset
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__portfolio_asset
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5FF77019B96B5643 ON portfolio_asset (portfolio_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_5FF770195DA1941 ON portfolio_asset (asset_id)
        SQL);
    }
}
