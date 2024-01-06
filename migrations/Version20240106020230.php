<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240106020230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE app_new_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE article_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE course_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE page_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE setting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE task_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE thread_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE thread_message_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_profile_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE app_new (id INT NOT NULL, title VARCHAR(255) NOT NULL, text TEXT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE article (id INT NOT NULL, title VARCHAR(255) NOT NULL, text TEXT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, title VARCHAR(255) NOT NULL, status VARCHAR(1) NOT NULL, text TEXT DEFAULT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE course (id INT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, short_description TEXT DEFAULT NULL, text TEXT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(1) NOT NULL, type VARCHAR(1) NOT NULL, position INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_169E6FB912469DE2 ON course (category_id)');
        $this->addSql('CREATE TABLE page (id INT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, text TEXT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_140AB62012469DE2 ON page (category_id)');
        $this->addSql('CREATE TABLE setting (id INT NOT NULL, title VARCHAR(255) NOT NULL, value TEXT NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE task (id INT NOT NULL, title VARCHAR(255) NOT NULL, text TEXT NOT NULL, status VARCHAR(1) NOT NULL, type VARCHAR(1) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE thread (id INT NOT NULL, owner_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_31204C837E3C61F9 ON thread (owner_id)');
        $this->addSql('CREATE TABLE thread_message (id INT NOT NULL, thread_id INT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, text TEXT NOT NULL, status VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_707D836E2904019 ON thread_message (thread_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, thread_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, status VARCHAR(1) NOT NULL, type VARCHAR(1) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E2904019 ON "user" (thread_id)');
        $this->addSql('CREATE TABLE user_profile (id INT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, admin_notification VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thread ADD CONSTRAINT FK_31204C837E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE thread_message ADD CONSTRAINT FK_707D836E2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649E2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE app_new_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE article_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE course_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE page_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE setting_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE task_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE thread_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE thread_message_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_profile_id_seq CASCADE');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT FK_169E6FB912469DE2');
        $this->addSql('ALTER TABLE page DROP CONSTRAINT FK_140AB62012469DE2');
        $this->addSql('ALTER TABLE thread DROP CONSTRAINT FK_31204C837E3C61F9');
        $this->addSql('ALTER TABLE thread_message DROP CONSTRAINT FK_707D836E2904019');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649E2904019');
        $this->addSql('DROP TABLE app_new');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE thread');
        $this->addSql('DROP TABLE thread_message');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_profile');
    }
}
