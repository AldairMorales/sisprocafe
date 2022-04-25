<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425165303 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acopio ADD analisis_fisico TINYINT(1) NOT NULL, ADD analisis_sensorial TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE analisis_fisico ADD acopio_id INT NOT NULL');
        $this->addSql('ALTER TABLE analisis_fisico ADD CONSTRAINT FK_43D689E8EBCEF997 FOREIGN KEY (acopio_id) REFERENCES acopio (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_43D689E8EBCEF997 ON analisis_fisico (acopio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acopio DROP analisis_fisico, DROP analisis_sensorial');
        $this->addSql('ALTER TABLE analisis_fisico DROP FOREIGN KEY FK_43D689E8EBCEF997');
        $this->addSql('DROP INDEX UNIQ_43D689E8EBCEF997 ON analisis_fisico');
        $this->addSql('ALTER TABLE analisis_fisico DROP acopio_id');
    }
}
