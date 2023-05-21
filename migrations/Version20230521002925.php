<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230521002925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE employee_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE esr_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE esrlabor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE esrpart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE esrpart_used_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE esrresult_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE account (id INT NOT NULL, assigned_to_id INT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4F85E0677 ON account (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4E7927C74 ON account (email)');
        $this->addSql('CREATE INDEX IDX_7D3656A4F4BD7827 ON account (assigned_to_id)');
        $this->addSql('CREATE TABLE employee (id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE esr (id INT NOT NULL, esr_result_id INT DEFAULT NULL, signed_by_id INT NOT NULL, serial_no VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, description TEXT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, problems TEXT NOT NULL, action_taken TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B44EAFC4083E8D1 ON esr (esr_result_id)');
        $this->addSql('CREATE INDEX IDX_B44EAFCD2EDD3FB ON esr (signed_by_id)');
        $this->addSql('CREATE TABLE esrlabor (id INT NOT NULL, esr_id INT NOT NULL, employee_id INT NOT NULL, labor_hours DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AE2665D6FBFD160 ON esrlabor (esr_id)');
        $this->addSql('CREATE INDEX IDX_AE2665D68C03F15C ON esrlabor (employee_id)');
        $this->addSql('CREATE TABLE esrpart (id INT NOT NULL, part_no VARCHAR(255) NOT NULL, description TEXT NOT NULL, price INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE esrpart_used (id INT NOT NULL, esr_id INT NOT NULL, esr_part_id INT NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BBBEB51BFBFD160 ON esrpart_used (esr_id)');
        $this->addSql('CREATE INDEX IDX_BBBEB51BD4A62BA6 ON esrpart_used (esr_part_id)');
        $this->addSql('CREATE TABLE esrresult (id INT NOT NULL, estimate_required BOOLEAN DEFAULT false NOT NULL, equipment_repair BOOLEAN DEFAULT false NOT NULL, pm_pi_ovp_esi BOOLEAN DEFAULT false NOT NULL, operation_calibration BOOLEAN DEFAULT false NOT NULL, electrical_safety_test BOOLEAN DEFAULT false NOT NULL, visual_inspection BOOLEAN DEFAULT false NOT NULL, passed BOOLEAN DEFAULT NULL, test_equipment_serial_no VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4F4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE esr ADD CONSTRAINT FK_B44EAFC4083E8D1 FOREIGN KEY (esr_result_id) REFERENCES esrresult (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE esr ADD CONSTRAINT FK_B44EAFCD2EDD3FB FOREIGN KEY (signed_by_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE esrlabor ADD CONSTRAINT FK_AE2665D6FBFD160 FOREIGN KEY (esr_id) REFERENCES esr (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE esrlabor ADD CONSTRAINT FK_AE2665D68C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE esrpart_used ADD CONSTRAINT FK_BBBEB51BFBFD160 FOREIGN KEY (esr_id) REFERENCES esr (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE esrpart_used ADD CONSTRAINT FK_BBBEB51BD4A62BA6 FOREIGN KEY (esr_part_id) REFERENCES esrpart (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE account_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE employee_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE esr_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE esrlabor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE esrpart_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE esrpart_used_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE esrresult_id_seq CASCADE');
        $this->addSql('ALTER TABLE account DROP CONSTRAINT FK_7D3656A4F4BD7827');
        $this->addSql('ALTER TABLE esr DROP CONSTRAINT FK_B44EAFC4083E8D1');
        $this->addSql('ALTER TABLE esr DROP CONSTRAINT FK_B44EAFCD2EDD3FB');
        $this->addSql('ALTER TABLE esrlabor DROP CONSTRAINT FK_AE2665D6FBFD160');
        $this->addSql('ALTER TABLE esrlabor DROP CONSTRAINT FK_AE2665D68C03F15C');
        $this->addSql('ALTER TABLE esrpart_used DROP CONSTRAINT FK_BBBEB51BFBFD160');
        $this->addSql('ALTER TABLE esrpart_used DROP CONSTRAINT FK_BBBEB51BD4A62BA6');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE esr');
        $this->addSql('DROP TABLE esrlabor');
        $this->addSql('DROP TABLE esrpart');
        $this->addSql('DROP TABLE esrpart_used');
        $this->addSql('DROP TABLE esrresult');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
