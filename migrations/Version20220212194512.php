<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220212194512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE unidad_equivalencia (id INT AUTO_INCREMENT NOT NULL, unidad_medida_id INT DEFAULT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, unidad VARCHAR(20) NOT NULL, valor_equivalencia INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_C4C222AFD17F50A6 (uuid), INDEX IDX_C4C222AF2E003F4 (unidad_medida_id), INDEX IDX_C4C222AF53C8D32C (propietario_id), INDEX IDX_C4C222AF24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE unidad_equivalencia ADD CONSTRAINT FK_C4C222AF2E003F4 FOREIGN KEY (unidad_medida_id) REFERENCES unidad_equivalencia (id)');
        $this->addSql('ALTER TABLE unidad_equivalencia ADD CONSTRAINT FK_C4C222AF53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE unidad_equivalencia ADD CONSTRAINT FK_C4C222AF24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unidad_equivalencia DROP FOREIGN KEY FK_C4C222AF2E003F4');
        $this->addSql('DROP TABLE unidad_equivalencia');
    }
}
