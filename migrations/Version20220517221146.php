<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517221146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analisis_fisico ADD exportable VARCHAR(255) DEFAULT NULL, ADD segunda VARCHAR(255) DEFAULT NULL, ADD bola VARCHAR(255) DEFAULT NULL, ADD cascara VARCHAR(255) DEFAULT NULL, ADD exportable_p NUMERIC(10, 2) DEFAULT NULL, ADD segunda_p NUMERIC(10, 2) DEFAULT NULL, ADD bola_p NUMERIC(10, 2) DEFAULT NULL, ADD cascara_p NUMERIC(10, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analisis_fisico DROP exportable, DROP segunda, DROP bola, DROP cascara, DROP exportable_p, DROP segunda_p, DROP bola_p, DROP cascara_p');
    }
}
