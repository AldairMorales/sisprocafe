<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329205429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificacion DROP FOREIGN KEY FK_A1F20253EAC40C8A');
        $this->addSql('DROP INDEX IDX_A1F20253EAC40C8A ON certificacion');
        $this->addSql('ALTER TABLE certificacion DROP detalle_periodo_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificacion ADD detalle_periodo_id INT NOT NULL');
        $this->addSql('ALTER TABLE certificacion ADD CONSTRAINT FK_A1F20253EAC40C8A FOREIGN KEY (detalle_periodo_id) REFERENCES detalle_periodo (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A1F20253EAC40C8A ON certificacion (detalle_periodo_id)');
    }
}
