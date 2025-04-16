<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416123035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__transactions AS SELECT id, user_id, asset_id, quantity, purchase_price FROM transactions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transactions
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transactions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, asset_id INTEGER NOT NULL, quantity INTEGER NOT NULL, price INTEGER NOT NULL, CONSTRAINT FK_EAA81A4CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EAA81A4C5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO transactions (id, user_id, asset_id, quantity, price) SELECT id, user_id, asset_id, quantity, purchase_price FROM __temp__transactions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__transactions
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EAA81A4CA76ED395 ON transactions (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EAA81A4C5DA1941 ON transactions (asset_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__transactions AS SELECT id, user_id, asset_id, quantity, price FROM transactions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transactions
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transactions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, asset_id INTEGER NOT NULL, quantity INTEGER NOT NULL, purchase_price INTEGER NOT NULL, CONSTRAINT FK_EAA81A4CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_EAA81A4C5DA1941 FOREIGN KEY (asset_id) REFERENCES asset (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO transactions (id, user_id, asset_id, quantity, purchase_price) SELECT id, user_id, asset_id, quantity, price FROM __temp__transactions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__transactions
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EAA81A4CA76ED395 ON transactions (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_EAA81A4C5DA1941 ON transactions (asset_id)
        SQL);
    }
}
