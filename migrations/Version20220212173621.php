<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220212173621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE unidad_medida (id INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, simbolo VARCHAR(10) NOT NULL, alias VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_7DA31363D17F50A6 (uuid), INDEX IDX_7DA313633397707A (categoria_id), INDEX IDX_7DA3136353C8D32C (propietario_id), INDEX IDX_7DA3136324DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE unidad_medida ADD CONSTRAINT FK_7DA313633397707A FOREIGN KEY (categoria_id) REFERENCES unidad_medida_categoria (id)');
        $this->addSql('ALTER TABLE unidad_medida ADD CONSTRAINT FK_7DA3136353C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE unidad_medida ADD CONSTRAINT FK_7DA3136324DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE unidad_medida');
    }
}
