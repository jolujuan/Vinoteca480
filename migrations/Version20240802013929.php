<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240802013929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mediciones ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE mediciones ALTER "año" SET NOT NULL');
        $this->addSql('ALTER TABLE mediciones ALTER color SET NOT NULL');
        $this->addSql('ALTER TABLE mediciones ALTER temperatura SET NOT NULL');
        $this->addSql('ALTER TABLE mediciones ALTER graduacion SET NOT NULL');
        $this->addSql('ALTER TABLE mediciones ALTER ph SET NOT NULL');
        $this->addSql('ALTER TABLE sensores DROP CONSTRAINT sensores_usuario_fk');
        $this->addSql('DROP INDEX IDX_F7493A62FCF8192D');
        $this->addSql('ALTER TABLE sensores ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE sensores ALTER nombre SET NOT NULL');
        $this->addSql('ALTER TABLE usuario ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE usuario ALTER nombre SET NOT NULL');
        $this->addSql('ALTER TABLE usuario ALTER apellido SET NOT NULL');
        $this->addSql('ALTER TABLE usuario ALTER email SET NOT NULL');
        $this->addSql('ALTER TABLE usuario ALTER "contraseña" SET NOT NULL');
        $this->addSql('ALTER TABLE vino DROP CONSTRAINT vino_usuario_fk');
        $this->addSql('DROP INDEX IDX_E65EA13FCF8192D');
        $this->addSql('ALTER TABLE vino ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE vino ALTER nombre SET NOT NULL');
        $this->addSql('ALTER TABLE vino ALTER "año" SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE sensores_id_seq');
        $this->addSql('SELECT setval(\'sensores_id_seq\', (SELECT MAX(id) FROM sensores))');
        $this->addSql('ALTER TABLE sensores ALTER id SET DEFAULT nextval(\'sensores_id_seq\')');
        $this->addSql('ALTER TABLE sensores ALTER nombre DROP NOT NULL');
        $this->addSql('ALTER TABLE sensores ADD CONSTRAINT sensores_usuario_fk FOREIGN KEY (id_usuario) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F7493A62FCF8192D ON sensores (id_usuario)');
        $this->addSql('CREATE SEQUENCE mediciones_id_seq');
        $this->addSql('SELECT setval(\'mediciones_id_seq\', (SELECT MAX(id) FROM mediciones))');
        $this->addSql('ALTER TABLE mediciones ALTER id SET DEFAULT nextval(\'mediciones_id_seq\')');
        $this->addSql('ALTER TABLE mediciones ALTER año DROP NOT NULL');
        $this->addSql('ALTER TABLE mediciones ALTER color DROP NOT NULL');
        $this->addSql('ALTER TABLE mediciones ALTER temperatura DROP NOT NULL');
        $this->addSql('ALTER TABLE mediciones ALTER graduacion DROP NOT NULL');
        $this->addSql('ALTER TABLE mediciones ALTER ph DROP NOT NULL');
        $this->addSql('CREATE SEQUENCE vino_id_seq');
        $this->addSql('SELECT setval(\'vino_id_seq\', (SELECT MAX(id) FROM vino))');
        $this->addSql('ALTER TABLE vino ALTER id SET DEFAULT nextval(\'vino_id_seq\')');
        $this->addSql('ALTER TABLE vino ALTER nombre DROP NOT NULL');
        $this->addSql('ALTER TABLE vino ALTER año DROP NOT NULL');
        $this->addSql('ALTER TABLE vino ADD CONSTRAINT vino_usuario_fk FOREIGN KEY (id_usuario) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E65EA13FCF8192D ON vino (id_usuario)');
        $this->addSql('CREATE SEQUENCE usuario_id_seq');
        $this->addSql('SELECT setval(\'usuario_id_seq\', (SELECT MAX(id) FROM usuario))');
        $this->addSql('ALTER TABLE usuario ALTER id SET DEFAULT nextval(\'usuario_id_seq\')');
        $this->addSql('ALTER TABLE usuario ALTER nombre DROP NOT NULL');
        $this->addSql('ALTER TABLE usuario ALTER apellido DROP NOT NULL');
        $this->addSql('ALTER TABLE usuario ALTER email DROP NOT NULL');
        $this->addSql('ALTER TABLE usuario ALTER contraseña DROP NOT NULL');
    }
}
