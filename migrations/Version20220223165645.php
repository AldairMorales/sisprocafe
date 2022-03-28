<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220223165645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE analisis_sensorial (id INT AUTO_INCREMENT NOT NULL, periodo_id INT NOT NULL, certificacion_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, fecha DATE NOT NULL, puntaje NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_D09A2751D17F50A6 (uuid), INDEX IDX_D09A27519C3921AB (periodo_id), INDEX IDX_D09A2751693EA4CA (certificacion_id), INDEX IDX_D09A275153C8D32C (propietario_id), INDEX IDX_D09A275124DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE analisis_sensorial ADD CONSTRAINT FK_D09A27519C3921AB FOREIGN KEY (periodo_id) REFERENCES periodo (id)');
        $this->addSql('ALTER TABLE analisis_sensorial ADD CONSTRAINT FK_D09A2751693EA4CA FOREIGN KEY (certificacion_id) REFERENCES certificacion (id)');
        $this->addSql('ALTER TABLE analisis_sensorial ADD CONSTRAINT FK_D09A275153C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE analisis_sensorial ADD CONSTRAINT FK_D09A275124DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE analisis_sensorial');
    }
}
