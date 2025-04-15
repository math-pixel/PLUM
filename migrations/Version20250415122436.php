<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415122436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__user_platform AS SELECT id, user_id, plateform_id, api_key FROM user_platform
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_platform
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_platform (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, platform_id INTEGER NOT NULL, api_key VARCHAR(255) NOT NULL, CONSTRAINT FK_D9DF34CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D9DF34CBFFE6496F FOREIGN KEY (platform_id) REFERENCES platform (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO user_platform (id, user_id, platform_id, api_key) SELECT id, user_id, plateform_id, api_key FROM __temp__user_platform
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__user_platform
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D9DF34CBA76ED395 ON user_platform (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D9DF34CBFFE6496F ON user_platform (platform_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TEMPORARY TABLE __temp__user_platform AS SELECT id, user_id, platform_id, api_key FROM user_platform
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_platform
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_platform (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, plateform_id INTEGER NOT NULL, api_key VARCHAR(255) NOT NULL, CONSTRAINT FK_D9DF34CBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D9DF34CBCCAA542F FOREIGN KEY (plateform_id) REFERENCES platform (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            INSERT INTO user_platform (id, user_id, plateform_id, api_key) SELECT id, user_id, platform_id, api_key FROM __temp__user_platform
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE __temp__user_platform
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D9DF34CBA76ED395 ON user_platform (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D9DF34CBCCAA542F ON user_platform (plateform_id)
        SQL);
    }
}
