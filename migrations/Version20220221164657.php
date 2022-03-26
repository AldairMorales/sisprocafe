<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221164657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detalle_periodo (id INT AUTO_INCREMENT NOT NULL, producto_id INT NOT NULL, acciones VARCHAR(30) NOT NULL, tara VARCHAR(15) NOT NULL, humedad_inicial VARCHAR(15) NOT NULL, muestra VARCHAR(15) NOT NULL, unidad_medida VARCHAR(10) NOT NULL, envase VARCHAR(10) NOT NULL, moneda VARCHAR(8) NOT NULL, INDEX IDX_3BC82A457645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detalle_periodo ADD CONSTRAINT FK_3BC82A457645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE certificacion ADD detalle_periodo_id INT NOT NULL');
        $this->addSql('ALTER TABLE certificacion ADD CONSTRAINT FK_A1F20253EAC40C8A FOREIGN KEY (detalle_periodo_id) REFERENCES detalle_periodo (id)');
        $this->addSql('CREATE INDEX IDX_A1F20253EAC40C8A ON certificacion (detalle_periodo_id)');
        $this->addSql('ALTER TABLE socio ADD tipo_documento VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificacion DROP FOREIGN KEY FK_A1F20253EAC40C8A');
        $this->addSql('DROP TABLE detalle_periodo');
        $this->addSql('DROP INDEX IDX_A1F20253EAC40C8A ON certificacion');
        $this->addSql('ALTER TABLE certificacion DROP detalle_periodo_id');
        $this->addSql('ALTER TABLE socio DROP tipo_documento');
    }
}
