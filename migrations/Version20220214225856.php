<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214225856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE periodo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, alias VARCHAR(16) NOT NULL, descripcion LONGTEXT DEFAULT NULL, fecha_inicio DATE NOT NULL, fecha_final DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periodo_producto (periodo_id INT NOT NULL, producto_id INT NOT NULL, INDEX IDX_3556BA9F9C3921AB (periodo_id), INDEX IDX_3556BA9F7645698E (producto_id), PRIMARY KEY(periodo_id, producto_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE periodo_producto ADD CONSTRAINT FK_3556BA9F9C3921AB FOREIGN KEY (periodo_id) REFERENCES periodo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE periodo_producto ADD CONSTRAINT FK_3556BA9F7645698E FOREIGN KEY (producto_id) REFERENCES producto (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE periodo_producto DROP FOREIGN KEY FK_3556BA9F9C3921AB');
        $this->addSql('DROP TABLE periodo');
        $this->addSql('DROP TABLE periodo_producto');
    }
}
