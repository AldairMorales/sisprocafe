<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220504171308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sensorial_usuario (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, analisis_sensorial_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, fragrancia NUMERIC(10, 2) DEFAULT NULL, sabor NUMERIC(10, 2) DEFAULT NULL, sabor_residual NUMERIC(10, 2) DEFAULT NULL, acidez NUMERIC(10, 2) DEFAULT NULL, cuerpo NUMERIC(10, 2) DEFAULT NULL, balance NUMERIC(10, 2) DEFAULT NULL, puntaje_catador NUMERIC(10, 2) DEFAULT NULL, uniformidad NUMERIC(10, 2) DEFAULT NULL, tasa_limpia NUMERIC(10, 2) DEFAULT NULL, dulzor NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_F98CD4D9D17F50A6 (uuid), INDEX IDX_F98CD4D9DB38439E (usuario_id), INDEX IDX_F98CD4D9C1204958 (analisis_sensorial_id), INDEX IDX_F98CD4D953C8D32C (propietario_id), INDEX IDX_F98CD4D924DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sensorial_usuario ADD CONSTRAINT FK_F98CD4D9DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE sensorial_usuario ADD CONSTRAINT FK_F98CD4D9C1204958 FOREIGN KEY (analisis_sensorial_id) REFERENCES analisis_sensorial (id)');
        $this->addSql('ALTER TABLE sensorial_usuario ADD CONSTRAINT FK_F98CD4D953C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE sensorial_usuario ADD CONSTRAINT FK_F98CD4D924DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sensorial_usuario');
    }
}
