<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508153512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analisis_fisico ADD exportable_ INT DEFAULT NULL, ADD bola_ INT DEFAULT NULL, ADD segunda_ INT DEFAULT NULL, ADD cascara_ INT DEFAULT NULL, CHANGE exportable exportable NUMERIC(10, 2) DEFAULT NULL, CHANGE bola bola NUMERIC(10, 2) DEFAULT NULL, CHANGE segunda segunda NUMERIC(10, 2) DEFAULT NULL, CHANGE cascara cascara NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE sensorial_usuario DROP uniformidad, DROP tasa_limpia, DROP dulzor');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analisis_fisico DROP exportable_, DROP bola_, DROP segunda_, DROP cascara_, CHANGE exportable exportable INT DEFAULT NULL, CHANGE bola bola INT DEFAULT NULL, CHANGE segunda segunda INT DEFAULT NULL, CHANGE cascara cascara INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sensorial_usuario ADD uniformidad NUMERIC(10, 2) DEFAULT NULL, ADD tasa_limpia NUMERIC(10, 2) DEFAULT NULL, ADD dulzor NUMERIC(10, 2) DEFAULT NULL');
    }
}
