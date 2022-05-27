<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527013442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detalle_traslado (id INT AUTO_INCREMENT NOT NULL, producto_id INT NOT NULL, certificacion_id INT DEFAULT NULL, traslados_id INT NOT NULL, peso VARCHAR(255) NOT NULL, cantidad VARCHAR(255) NOT NULL, INDEX IDX_772909137645698E (producto_id), INDEX IDX_77290913693EA4CA (certificacion_id), INDEX IDX_77290913CFD44BAD (traslados_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traslado (id INT AUTO_INCREMENT NOT NULL, almacen_origen_id INT DEFAULT NULL, almacen_destino_id INT DEFAULT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, fecha_salida DATE NOT NULL, numero_guia VARCHAR(9) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_AF6CFC27D17F50A6 (uuid), INDEX IDX_AF6CFC2730032D1F (almacen_origen_id), INDEX IDX_AF6CFC278C48E45E (almacen_destino_id), INDEX IDX_AF6CFC2753C8D32C (propietario_id), INDEX IDX_AF6CFC2724DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detalle_traslado ADD CONSTRAINT FK_772909137645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE detalle_traslado ADD CONSTRAINT FK_77290913693EA4CA FOREIGN KEY (certificacion_id) REFERENCES certificacion (id)');
        $this->addSql('ALTER TABLE detalle_traslado ADD CONSTRAINT FK_77290913CFD44BAD FOREIGN KEY (traslados_id) REFERENCES traslado (id)');
        $this->addSql('ALTER TABLE traslado ADD CONSTRAINT FK_AF6CFC2730032D1F FOREIGN KEY (almacen_origen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE traslado ADD CONSTRAINT FK_AF6CFC278C48E45E FOREIGN KEY (almacen_destino_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE traslado ADD CONSTRAINT FK_AF6CFC2753C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE traslado ADD CONSTRAINT FK_AF6CFC2724DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_traslado DROP FOREIGN KEY FK_77290913CFD44BAD');
        $this->addSql('DROP TABLE detalle_traslado');
        $this->addSql('DROP TABLE traslado');
    }
}
