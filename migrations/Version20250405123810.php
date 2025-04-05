<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250405123810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_platform AS SELECT id, api_key FROM user_platform');
        $this->addSql('DROP TABLE user_platform');
        $this->addSql('CREATE TABLE user_platform (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, plateform_id INTEGER NOT NULL, api_key VARCHAR(255) NOT NULL, CONSTRAINT FK_D9DF34CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D9DF34CBCCAA542F FOREIGN KEY (plateform_id) REFERENCES platform (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_platform (id, api_key) SELECT id, api_key FROM __temp__user_platform');
        $this->addSql('DROP TABLE __temp__user_platform');
        $this->addSql('CREATE INDEX IDX_D9DF34CBA76ED395 ON user_platform (user_id)');
        $this->addSql('CREATE INDEX IDX_D9DF34CBCCAA542F ON user_platform (plateform_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_platform AS SELECT id, api_key FROM user_platform');
        $this->addSql('DROP TABLE user_platform');
        $this->addSql('CREATE TABLE user_platform (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, api_key VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user_platform (id, api_key) SELECT id, api_key FROM __temp__user_platform');
        $this->addSql('DROP TABLE __temp__user_platform');
    }
}
