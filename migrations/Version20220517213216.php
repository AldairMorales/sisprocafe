<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220517213216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analisis_fisico CHANGE exportable exportable VARCHAR(255) DEFAULT NULL, CHANGE bola bola VARCHAR(255) DEFAULT NULL, CHANGE segunda segunda VARCHAR(255) DEFAULT NULL, CHANGE cascara cascara VARCHAR(255) DEFAULT NULL, CHANGE exportable_ exportable_ NUMERIC(10, 2) DEFAULT NULL, CHANGE bola_ bola_ NUMERIC(10, 2) DEFAULT NULL, CHANGE segunda_ segunda_ NUMERIC(10, 2) DEFAULT NULL, CHANGE cascara_ cascara_ NUMERIC(10, 2) DEFAULT NULL, CHANGE tipo tipo VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analisis_fisico CHANGE exportable_ exportable_ INT DEFAULT NULL, CHANGE bola_ bola_ INT DEFAULT NULL, CHANGE segunda_ segunda_ INT DEFAULT NULL, CHANGE cascara_ cascara_ INT DEFAULT NULL, CHANGE exportable exportable NUMERIC(10, 2) DEFAULT NULL, CHANGE bola bola NUMERIC(10, 2) DEFAULT NULL, CHANGE segunda segunda NUMERIC(10, 2) DEFAULT NULL, CHANGE cascara cascara NUMERIC(10, 2) DEFAULT NULL, CHANGE tipo tipo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
