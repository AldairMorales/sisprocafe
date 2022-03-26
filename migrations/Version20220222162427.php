<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222162427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_periodo ADD propietario_id INT DEFAULT NULL, ADD config_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD activo TINYINT(1) NOT NULL, ADD uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE detalle_periodo ADD CONSTRAINT FK_3BC82A4553C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE detalle_periodo ADD CONSTRAINT FK_3BC82A4524DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BC82A45D17F50A6 ON detalle_periodo (uuid)');
        $this->addSql('CREATE INDEX IDX_3BC82A4553C8D32C ON detalle_periodo (propietario_id)');
        $this->addSql('CREATE INDEX IDX_3BC82A4524DB0683 ON detalle_periodo (config_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_periodo DROP FOREIGN KEY FK_3BC82A4553C8D32C');
        $this->addSql('ALTER TABLE detalle_periodo DROP FOREIGN KEY FK_3BC82A4524DB0683');
        $this->addSql('DROP INDEX UNIQ_3BC82A45D17F50A6 ON detalle_periodo');
        $this->addSql('DROP INDEX IDX_3BC82A4553C8D32C ON detalle_periodo');
        $this->addSql('DROP INDEX IDX_3BC82A4524DB0683 ON detalle_periodo');
        $this->addSql('ALTER TABLE detalle_periodo DROP propietario_id, DROP config_id, DROP created_at, DROP updated_at, DROP activo, DROP uuid');
    }
}
