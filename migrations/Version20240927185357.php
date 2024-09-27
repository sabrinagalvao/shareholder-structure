<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240927185357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE company_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_id_seq CASCADE');
        $this->addSql('CREATE TABLE company (id UUID NOT NULL, cnpj VARCHAR(14) NOT NULL, name VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN company.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE person (id UUID NOT NULL, cpf VARCHAR(11) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN person.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE person_company (person_id UUID NOT NULL, company_id UUID NOT NULL, PRIMARY KEY(person_id, company_id))');
        $this->addSql('CREATE INDEX IDX_6D21BAC6217BBB47 ON person_company (person_id)');
        $this->addSql('CREATE INDEX IDX_6D21BAC6979B1AD6 ON person_company (company_id)');
        $this->addSql('COMMENT ON COLUMN person_company.person_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN person_company.company_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE person_company ADD CONSTRAINT FK_6D21BAC6217BBB47 FOREIGN KEY (person_id) REFERENCES person (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE person_company ADD CONSTRAINT FK_6D21BAC6979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE company_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE person_company DROP CONSTRAINT FK_6D21BAC6217BBB47');
        $this->addSql('ALTER TABLE person_company DROP CONSTRAINT FK_6D21BAC6979B1AD6');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE person_company');
    }
}
