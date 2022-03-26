<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220325164722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acopio (id INT AUTO_INCREMENT NOT NULL, periodo_id INT NOT NULL, socio_id INT NOT NULL, certificacion_id INT NOT NULL, almacen_id INT NOT NULL, fecha DATE NOT NULL, tikect VARCHAR(9) NOT NULL, peso_bruto INT NOT NULL, cantidad INT NOT NULL, tara_por_saco NUMERIC(10, 2) NOT NULL, tara_de_sacos NUMERIC(10, 2) NOT NULL, peso_quintales NUMERIC(10, 2) NOT NULL, peso_neto NUMERIC(10, 0) NOT NULL, observaciones LONGTEXT DEFAULT NULL, INDEX IDX_F27E53E39C3921AB (periodo_id), INDEX IDX_F27E53E3DA04E6A9 (socio_id), INDEX IDX_F27E53E3693EA4CA (certificacion_id), INDEX IDX_F27E53E39C9C9E68 (almacen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E39C3921AB FOREIGN KEY (periodo_id) REFERENCES periodo (id)');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E3DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E3693EA4CA FOREIGN KEY (certificacion_id) REFERENCES certificacion (id)');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E39C9C9E68 FOREIGN KEY (almacen_id) REFERENCES almacen (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE acopio');
    }
}
