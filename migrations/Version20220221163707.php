<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221163707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE atributos_catacion (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_EB9712BAD17F50A6 (uuid), INDEX IDX_EB9712BA53C8D32C (propietario_id), INDEX IDX_EB9712BA24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detalle_atributos (id INT AUTO_INCREMENT NOT NULL, atributo_catacion_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_37E9D312D17F50A6 (uuid), INDEX IDX_37E9D3129F49337E (atributo_catacion_id), INDEX IDX_37E9D31253C8D32C (propietario_id), INDEX IDX_37E9D31224DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atributos_catacion ADD CONSTRAINT FK_EB9712BA53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE atributos_catacion ADD CONSTRAINT FK_EB9712BA24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE detalle_atributos ADD CONSTRAINT FK_37E9D3129F49337E FOREIGN KEY (atributo_catacion_id) REFERENCES atributos_catacion (id)');
        $this->addSql('ALTER TABLE detalle_atributos ADD CONSTRAINT FK_37E9D31253C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE detalle_atributos ADD CONSTRAINT FK_37E9D31224DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_atributos DROP FOREIGN KEY FK_37E9D3129F49337E');
        $this->addSql('DROP TABLE atributos_catacion');
        $this->addSql('DROP TABLE detalle_atributos');
    }
}
