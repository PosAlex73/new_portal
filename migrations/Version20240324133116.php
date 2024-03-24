<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240324133116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE course_bug_report_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE course_bug_report (id INT NOT NULL, reporter_id INT DEFAULT NULL, course_id INT NOT NULL, title VARCHAR(255) NOT NULL, text TEXT NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(1) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_291092F9E1CFE6F5 ON course_bug_report (reporter_id)');
        $this->addSql('CREATE INDEX IDX_291092F9591CC992 ON course_bug_report (course_id)');
        $this->addSql('ALTER TABLE course_bug_report ADD CONSTRAINT FK_291092F9E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course_bug_report ADD CONSTRAINT FK_291092F9591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE course_bug_report_id_seq CASCADE');
        $this->addSql('ALTER TABLE course_bug_report DROP CONSTRAINT FK_291092F9E1CFE6F5');
        $this->addSql('ALTER TABLE course_bug_report DROP CONSTRAINT FK_291092F9591CC992');
        $this->addSql('DROP TABLE course_bug_report');
    }
}
