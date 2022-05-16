<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513193026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pago_acopio (id INT AUTO_INCREMENT NOT NULL, acopio_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, fecha DATE NOT NULL, precio_base VARCHAR(255) DEFAULT NULL, precio_final NUMERIC(10, 2) DEFAULT NULL, descripcion VARCHAR(100) DEFAULT NULL, estado TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_C68B935D17F50A6 (uuid), UNIQUE INDEX UNIQ_C68B935EBCEF997 (acopio_id), INDEX IDX_C68B93553C8D32C (propietario_id), INDEX IDX_C68B93524DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pago_acopio ADD CONSTRAINT FK_C68B935EBCEF997 FOREIGN KEY (acopio_id) REFERENCES acopio (id)');
        $this->addSql('ALTER TABLE pago_acopio ADD CONSTRAINT FK_C68B93553C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE pago_acopio ADD CONSTRAINT FK_C68B93524DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pago_acopio');
    }
}
