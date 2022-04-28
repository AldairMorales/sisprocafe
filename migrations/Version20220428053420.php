<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220428053420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE analisissensorial_fragrancia (analisis_sensorial_id INT NOT NULL, detalle_atributos_id INT NOT NULL, INDEX IDX_F142E690C1204958 (analisis_sensorial_id), INDEX IDX_F142E690A207E19 (detalle_atributos_id), PRIMARY KEY(analisis_sensorial_id, detalle_atributos_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE analisissensorial_sabor (analisis_sensorial_id INT NOT NULL, detalle_atributos_id INT NOT NULL, INDEX IDX_EB163008C1204958 (analisis_sensorial_id), INDEX IDX_EB163008A207E19 (detalle_atributos_id), PRIMARY KEY(analisis_sensorial_id, detalle_atributos_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE analisissensorial_balance (analisis_sensorial_id INT NOT NULL, detalle_atributos_id INT NOT NULL, INDEX IDX_57ABEAC2C1204958 (analisis_sensorial_id), INDEX IDX_57ABEAC2A207E19 (detalle_atributos_id), PRIMARY KEY(analisis_sensorial_id, detalle_atributos_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE analisissensorial_fragrancia ADD CONSTRAINT FK_F142E690C1204958 FOREIGN KEY (analisis_sensorial_id) REFERENCES analisis_sensorial (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE analisissensorial_fragrancia ADD CONSTRAINT FK_F142E690A207E19 FOREIGN KEY (detalle_atributos_id) REFERENCES detalle_atributos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE analisissensorial_sabor ADD CONSTRAINT FK_EB163008C1204958 FOREIGN KEY (analisis_sensorial_id) REFERENCES analisis_sensorial (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE analisissensorial_sabor ADD CONSTRAINT FK_EB163008A207E19 FOREIGN KEY (detalle_atributos_id) REFERENCES detalle_atributos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE analisissensorial_balance ADD CONSTRAINT FK_57ABEAC2C1204958 FOREIGN KEY (analisis_sensorial_id) REFERENCES analisis_sensorial (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE analisissensorial_balance ADD CONSTRAINT FK_57ABEAC2A207E19 FOREIGN KEY (detalle_atributos_id) REFERENCES detalle_atributos (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE analisissensorial_fragrancia');
        $this->addSql('DROP TABLE analisissensorial_sabor');
        $this->addSql('DROP TABLE analisissensorial_balance');
    }
}
