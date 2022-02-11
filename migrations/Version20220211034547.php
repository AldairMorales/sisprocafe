<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220211034547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE almacen (id INT AUTO_INCREMENT NOT NULL, tipo_almacen_id INT NOT NULL, ubicacion_id INT DEFAULT NULL, empresa_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, direccion VARCHAR(80) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_D5B2D250D17F50A6 (uuid), INDEX IDX_D5B2D250D1A9C40 (tipo_almacen_id), INDEX IDX_D5B2D25057E759E8 (ubicacion_id), INDEX IDX_D5B2D250521E1991 (empresa_id), INDEX IDX_D5B2D25053C8D32C (propietario_id), INDEX IDX_D5B2D25024DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D250D1A9C40 FOREIGN KEY (tipo_almacen_id) REFERENCES tipo_almacen (id)');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D25057E759E8 FOREIGN KEY (ubicacion_id) REFERENCES reporte_territorial (id)');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D250521E1991 FOREIGN KEY (empresa_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D25053C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D25024DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE almacen DROP FOREIGN KEY FK_D5B2D250521E1991');
        $this->addSql('DROP TABLE almacen');
    }
}
