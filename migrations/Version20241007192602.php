<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007192602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE favorite_course_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE favorite_course (id INT NOT NULL, user_like_id INT DEFAULT NULL, course_id INT DEFAULT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2A2B0343DD96E438 ON favorite_course (user_like_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2A2B0343591CC992 ON favorite_course (course_id)');
        $this->addSql('ALTER TABLE favorite_course ADD CONSTRAINT FK_2A2B0343DD96E438 FOREIGN KEY (user_like_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_course ADD CONSTRAINT FK_2A2B0343591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE course ALTER is_new DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE favorite_course_id_seq CASCADE');
        $this->addSql('ALTER TABLE favorite_course DROP CONSTRAINT FK_2A2B0343DD96E438');
        $this->addSql('ALTER TABLE favorite_course DROP CONSTRAINT FK_2A2B0343591CC992');
        $this->addSql('DROP TABLE favorite_course');
        $this->addSql('ALTER TABLE course ALTER is_new SET DEFAULT false');
    }
}
