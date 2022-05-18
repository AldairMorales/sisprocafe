<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517224838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acopio ADD peso_bruto VARCHAR(255) DEFAULT NULL, ADD cantidad VARCHAR(255) DEFAULT NULL, ADD tara_de_sacos VARCHAR(255) DEFAULT NULL, ADD peso_quintales VARCHAR(255) DEFAULT NULL, ADD peso_neto VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE analisis_fisico CHANGE exportable exportable VARCHAR(255) DEFAULT NULL, CHANGE segunda segunda VARCHAR(255) DEFAULT NULL, CHANGE bola bola VARCHAR(255) DEFAULT NULL, CHANGE cascara cascara VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acopio DROP peso_bruto, DROP cantidad, DROP tara_de_sacos, DROP peso_quintales, DROP peso_neto');
        $this->addSql('ALTER TABLE analisis_fisico CHANGE exportable exportable VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE segunda segunda VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bola bola VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cascara cascara VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
