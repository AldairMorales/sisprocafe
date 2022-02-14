<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211220854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE socio (id INT AUTO_INCREMENT NOT NULL, estado_id INT NOT NULL, fecha_ingreso DATE NOT NULL, codigo VARCHAR(16) NOT NULL, tipo TINYINT(1) NOT NULL, nombres VARCHAR(50) NOT NULL, apellido_paterno VARCHAR(30) NOT NULL, apellido_materno VARCHAR(30) NOT NULL, sexo TINYINT(1) NOT NULL, numero_documento VARCHAR(15) NOT NULL, telefono VARCHAR(9) NOT NULL, fecha_nacimiento DATE NOT NULL, conyugue_nombre VARCHAR(20) DEFAULT NULL, conyugue_documento VARCHAR(15) DEFAULT NULL, ruc VARCHAR(11) NOT NULL, estado_ruc TINYINT(1) NOT NULL, INDEX IDX_38B653099F5A440B (estado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE socio ADD CONSTRAINT FK_38B653099F5A440B FOREIGN KEY (estado_id) REFERENCES estado_socio (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE socio');
    }
}
