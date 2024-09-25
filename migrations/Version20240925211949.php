<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925211949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE course_link_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE course_link (id INT NOT NULL, title VARCHAR(1024) NOT NULL, url VARCHAR(2048) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ыeфstatus VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE course_link_course (course_link_id INT NOT NULL, course_id INT NOT NULL, PRIMARY KEY(course_link_id, course_id))');
        $this->addSql('CREATE INDEX IDX_3341BE2A567079D ON course_link_course (course_link_id)');
        $this->addSql('CREATE INDEX IDX_3341BE2591CC992 ON course_link_course (course_id)');
        $this->addSql('ALTER TABLE course_link_course ADD CONSTRAINT FK_3341BE2A567079D FOREIGN KEY (course_link_id) REFERENCES course_link (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_link_course ADD CONSTRAINT FK_3341BE2591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE course_link_id_seq CASCADE');
        $this->addSql('ALTER TABLE course_link_course DROP CONSTRAINT FK_3341BE2A567079D');
        $this->addSql('ALTER TABLE course_link_course DROP CONSTRAINT FK_3341BE2591CC992');
        $this->addSql('DROP TABLE course_link');
        $this->addSql('DROP TABLE course_link_course');
    }
}
