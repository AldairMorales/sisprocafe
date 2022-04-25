<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425202640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analisis_sensorial ADD acopio_id INT NOT NULL');
        $this->addSql('ALTER TABLE analisis_sensorial ADD CONSTRAINT FK_D09A2751EBCEF997 FOREIGN KEY (acopio_id) REFERENCES acopio (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D09A2751EBCEF997 ON analisis_sensorial (acopio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE analisis_sensorial DROP FOREIGN KEY FK_D09A2751EBCEF997');
        $this->addSql('DROP INDEX UNIQ_D09A2751EBCEF997 ON analisis_sensorial');
        $this->addSql('ALTER TABLE analisis_sensorial DROP acopio_id');
    }
}
