<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241021191102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD course_rating_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB98893AF6A FOREIGN KEY (course_rating_id) REFERENCES course_rating (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_169E6FB98893AF6A ON course (course_rating_id)');
        $this->addSql('ALTER TABLE course_rating ADD created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE course_rating ADD updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE course DROP CONSTRAINT FK_169E6FB98893AF6A');
        $this->addSql('DROP INDEX IDX_169E6FB98893AF6A');
        $this->addSql('ALTER TABLE course DROP course_rating_id');
        $this->addSql('ALTER TABLE course_rating DROP created');
        $this->addSql('ALTER TABLE course_rating DROP updated');
    }
}
