<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505175149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certificacion_valor (id INT AUTO_INCREMENT NOT NULL, certificacion_id INT NOT NULL, detalle_certificacion_id INT DEFAULT NULL, valor INT NOT NULL, diferencia INT NOT NULL, INDEX IDX_A0BE0BF6693EA4CA (certificacion_id), INDEX IDX_A0BE0BF6B8EF4374 (detalle_certificacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE precio_acopio (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, precio_base NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_9884E92D17F50A6 (uuid), INDEX IDX_9884E9253C8D32C (propietario_id), INDEX IDX_9884E9224DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendimiento (id INT AUTO_INCREMENT NOT NULL, detalle_rendimiento_id INT DEFAULT NULL, valor INT NOT NULL, incremento INT NOT NULL, INDEX IDX_DC8E40338A7A2916 (detalle_rendimiento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certificacion_valor ADD CONSTRAINT FK_A0BE0BF6693EA4CA FOREIGN KEY (certificacion_id) REFERENCES certificacion (id)');
        $this->addSql('ALTER TABLE certificacion_valor ADD CONSTRAINT FK_A0BE0BF6B8EF4374 FOREIGN KEY (detalle_certificacion_id) REFERENCES precio_acopio (id)');
        $this->addSql('ALTER TABLE precio_acopio ADD CONSTRAINT FK_9884E9253C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE precio_acopio ADD CONSTRAINT FK_9884E9224DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE rendimiento ADD CONSTRAINT FK_DC8E40338A7A2916 FOREIGN KEY (detalle_rendimiento_id) REFERENCES precio_acopio (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificacion_valor DROP FOREIGN KEY FK_A0BE0BF6B8EF4374');
        $this->addSql('ALTER TABLE rendimiento DROP FOREIGN KEY FK_DC8E40338A7A2916');
        $this->addSql('DROP TABLE certificacion_valor');
        $this->addSql('DROP TABLE precio_acopio');
        $this->addSql('DROP TABLE rendimiento');
    }
}
