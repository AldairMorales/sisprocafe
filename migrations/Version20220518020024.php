<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220518020024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acopio CHANGE peso_bruto peso_bruto VARCHAR(255) DEFAULT NULL, CHANGE cantidad cantidad VARCHAR(255) DEFAULT NULL, CHANGE tara_de_sacos tara_de_sacos VARCHAR(255) DEFAULT NULL, CHANGE peso_quintales peso_quintales VARCHAR(255) DEFAULT NULL, CHANGE peso_neto peso_neto VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE analisis_fisico CHANGE exportable exportable VARCHAR(255) DEFAULT NULL, CHANGE segunda segunda VARCHAR(255) DEFAULT NULL, CHANGE bola bola VARCHAR(255) DEFAULT NULL, CHANGE cascara cascara VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acopio CHANGE peso_bruto peso_bruto VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cantidad cantidad VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tara_de_sacos tara_de_sacos VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE peso_quintales peso_quintales VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE peso_neto peso_neto VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE analisis_fisico CHANGE exportable exportable VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE segunda segunda VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bola bola VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE cascara cascara VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
