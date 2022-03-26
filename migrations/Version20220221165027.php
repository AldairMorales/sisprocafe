<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221165027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_periodo ADD periodo_id INT NOT NULL');
        $this->addSql('ALTER TABLE detalle_periodo ADD CONSTRAINT FK_3BC82A459C3921AB FOREIGN KEY (periodo_id) REFERENCES periodo (id)');
        $this->addSql('CREATE INDEX IDX_3BC82A459C3921AB ON detalle_periodo (periodo_id)');
        $this->addSql('ALTER TABLE periodo ADD estado VARCHAR(10) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_periodo DROP FOREIGN KEY FK_3BC82A459C3921AB');
        $this->addSql('DROP INDEX IDX_3BC82A459C3921AB ON detalle_periodo');
        $this->addSql('ALTER TABLE detalle_periodo DROP periodo_id');
        $this->addSql('ALTER TABLE periodo DROP estado');
    }
}
