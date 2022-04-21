<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421190654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE almacen DROP FOREIGN KEY FK_D5B2D250521E1991');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D250521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE almacen DROP FOREIGN KEY FK_D5B2D250521E1991');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D250521E1991 FOREIGN KEY (empresa_id) REFERENCES almacen (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
