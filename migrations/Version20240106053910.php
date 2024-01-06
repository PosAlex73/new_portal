<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240106053910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_progress_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_progress (id INT NOT NULL, owner_id INT DEFAULT NULL, course_id INT DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, data TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C28C16467E3C61F9 ON user_progress (owner_id)');
        $this->addSql('CREATE INDEX IDX_C28C1646591CC992 ON user_progress (course_id)');
        $this->addSql('ALTER TABLE user_progress ADD CONSTRAINT FK_C28C16467E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_progress ADD CONSTRAINT FK_C28C1646591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_profile ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB4057E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D95AB4057E3C61F9 ON user_profile (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE user_progress_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_progress DROP CONSTRAINT FK_C28C16467E3C61F9');
        $this->addSql('ALTER TABLE user_progress DROP CONSTRAINT FK_C28C1646591CC992');
        $this->addSql('DROP TABLE user_progress');
        $this->addSql('ALTER TABLE user_profile DROP CONSTRAINT FK_D95AB4057E3C61F9');
        $this->addSql('DROP INDEX UNIQ_D95AB4057E3C61F9');
        $this->addSql('ALTER TABLE user_profile DROP owner_id');
    }
}
