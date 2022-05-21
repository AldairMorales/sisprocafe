<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220521194653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pago_acopio (id INT AUTO_INCREMENT NOT NULL, acopio_id INT DEFAULT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, fecha DATE NOT NULL, precio_base VARCHAR(255) DEFAULT NULL, precio_final NUMERIC(10, 2) DEFAULT NULL, descripcion VARCHAR(100) DEFAULT NULL, estado TINYINT(1) DEFAULT NULL, pago_acopio NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_C68B935D17F50A6 (uuid), UNIQUE INDEX UNIQ_C68B935EBCEF997 (acopio_id), INDEX IDX_C68B93553C8D32C (propietario_id), INDEX IDX_C68B93524DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pago_acopio ADD CONSTRAINT FK_C68B935EBCEF997 FOREIGN KEY (acopio_id) REFERENCES acopio (id)');
        $this->addSql('ALTER TABLE pago_acopio ADD CONSTRAINT FK_C68B93553C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE pago_acopio ADD CONSTRAINT FK_C68B93524DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE acopio ADD estado_id INT NOT NULL, CHANGE peso_bruto peso_bruto VARCHAR(255) DEFAULT NULL, CHANGE cantidad cantidad VARCHAR(255) DEFAULT NULL, CHANGE tara_de_sacos tara_de_sacos VARCHAR(255) DEFAULT NULL, CHANGE peso_quintales peso_quintales VARCHAR(255) DEFAULT NULL, CHANGE peso_neto peso_neto VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E39F5A440B FOREIGN KEY (estado_id) REFERENCES parametro (id)');
        $this->addSql('CREATE INDEX IDX_F27E53E39F5A440B ON acopio (estado_id)');
        $this->addSql('ALTER TABLE analisis_fisico ADD exportable_p NUMERIC(10, 2) DEFAULT NULL, ADD segunda_p NUMERIC(10, 2) DEFAULT NULL, ADD bola_p NUMERIC(10, 2) DEFAULT NULL, ADD cascara_p NUMERIC(10, 2) DEFAULT NULL, CHANGE exportable exportable VARCHAR(255) DEFAULT NULL, CHANGE bola bola VARCHAR(255) DEFAULT NULL, CHANGE segunda segunda VARCHAR(255) DEFAULT NULL, CHANGE cascara cascara VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sensorial_usuario DROP uniformidad, DROP tasa_limpia, DROP dulzor');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pago_acopio');
        $this->addSql('ALTER TABLE acopio DROP FOREIGN KEY FK_F27E53E39F5A440B');
        $this->addSql('DROP INDEX IDX_F27E53E39F5A440B ON acopio');
        $this->addSql('ALTER TABLE acopio DROP estado_id, CHANGE peso_bruto peso_bruto INT NOT NULL, CHANGE cantidad cantidad INT NOT NULL, CHANGE tara_de_sacos tara_de_sacos NUMERIC(10, 2) NOT NULL, CHANGE peso_quintales peso_quintales NUMERIC(10, 2) NOT NULL, CHANGE peso_neto peso_neto NUMERIC(10, 0) NOT NULL');
        $this->addSql('ALTER TABLE analisis_fisico DROP exportable_p, DROP segunda_p, DROP bola_p, DROP cascara_p, CHANGE exportable exportable INT DEFAULT NULL, CHANGE segunda segunda INT DEFAULT NULL, CHANGE bola bola INT DEFAULT NULL, CHANGE cascara cascara INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sensorial_usuario ADD uniformidad NUMERIC(10, 2) DEFAULT NULL, ADD tasa_limpia NUMERIC(10, 2) DEFAULT NULL, ADD dulzor NUMERIC(10, 2) DEFAULT NULL');
    }
}
