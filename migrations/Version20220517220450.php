<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517220450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analisis_fisico ADD exportable_p NUMERIC(10, 2) DEFAULT NULL, ADD bola_p NUMERIC(10, 2) DEFAULT NULL, ADD segunda_p NUMERIC(10, 2) DEFAULT NULL, ADD cascara_p NUMERIC(10, 2) DEFAULT NULL, DROP exportable_, DROP bola_, DROP segunda_, DROP cascara_, DROP tipo, CHANGE exportable exportable VARCHAR(255) DEFAULT NULL, CHANGE bola bola VARCHAR(255) DEFAULT NULL, CHANGE segunda segunda VARCHAR(255) DEFAULT NULL, CHANGE cascara cascara VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analisis_fisico ADD exportable_ NUMERIC(10, 2) DEFAULT NULL, ADD bola_ NUMERIC(10, 2) DEFAULT NULL, ADD segunda_ NUMERIC(10, 2) DEFAULT NULL, ADD cascara_ NUMERIC(10, 2) DEFAULT NULL, ADD tipo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP exportable_p, DROP bola_p, DROP segunda_p, DROP cascara_p, CHANGE exportable exportable VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bola bola VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE segunda segunda VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cascara cascara VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
