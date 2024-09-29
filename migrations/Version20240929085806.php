<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240929085806 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE course_tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE course_tag (id INT NOT NULL, title VARCHAR(255) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE course_tag_course (course_tag_id INT NOT NULL, course_id INT NOT NULL, PRIMARY KEY(course_tag_id, course_id))');
        $this->addSql('CREATE INDEX IDX_203D681614EAA25C ON course_tag_course (course_tag_id)');
        $this->addSql('CREATE INDEX IDX_203D6816591CC992 ON course_tag_course (course_id)');
        $this->addSql('ALTER TABLE course_tag_course ADD CONSTRAINT FK_203D681614EAA25C FOREIGN KEY (course_tag_id) REFERENCES course_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_tag_course ADD CONSTRAINT FK_203D6816591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE course_tag_id_seq CASCADE');
        $this->addSql('ALTER TABLE course_tag_course DROP CONSTRAINT FK_203D681614EAA25C');
        $this->addSql('ALTER TABLE course_tag_course DROP CONSTRAINT FK_203D6816591CC992');
        $this->addSql('DROP TABLE course_tag');
        $this->addSql('DROP TABLE course_tag_course');
    }
}
