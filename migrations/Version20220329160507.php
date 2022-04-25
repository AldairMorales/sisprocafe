<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329160507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE almacen (id INT AUTO_INCREMENT NOT NULL, tipo_almacen_id INT NOT NULL, ubicacion_id INT DEFAULT NULL, empresa_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, direccion VARCHAR(80) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_D5B2D250D17F50A6 (uuid), INDEX IDX_D5B2D250D1A9C40 (tipo_almacen_id), INDEX IDX_D5B2D25057E759E8 (ubicacion_id), INDEX IDX_D5B2D250521E1991 (empresa_id), INDEX IDX_D5B2D25053C8D32C (propietario_id), INDEX IDX_D5B2D25024DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE analisis_fisico (id INT AUTO_INCREMENT NOT NULL, certificacion_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, fecha DATE NOT NULL, muestra INT NOT NULL, exportable INT DEFAULT NULL, bola INT DEFAULT NULL, segunda INT DEFAULT NULL, humedad INT DEFAULT NULL, descripcion VARCHAR(100) NOT NULL, cascara INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_43D689E8D17F50A6 (uuid), INDEX IDX_43D689E8693EA4CA (certificacion_id), INDEX IDX_43D689E853C8D32C (propietario_id), INDEX IDX_43D689E824DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE analisis_sensorial (id INT AUTO_INCREMENT NOT NULL, periodo_id INT NOT NULL, certificacion_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, fecha DATE NOT NULL, puntaje NUMERIC(10, 2) DEFAULT NULL, fragrancia NUMERIC(10, 2) DEFAULT NULL, sabor NUMERIC(10, 2) DEFAULT NULL, sabor_residual NUMERIC(10, 2) DEFAULT NULL, acidez NUMERIC(10, 2) DEFAULT NULL, cuerpo NUMERIC(10, 2) DEFAULT NULL, balance NUMERIC(10, 2) DEFAULT NULL, puntaje_catador NUMERIC(10, 2) DEFAULT NULL, descripcion VARCHAR(50) DEFAULT NULL, uniformidad NUMERIC(10, 2) DEFAULT NULL, tasa_limpia NUMERIC(10, 2) DEFAULT NULL, dulzor NUMERIC(10, 2) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_D09A2751D17F50A6 (uuid), INDEX IDX_D09A27519C3921AB (periodo_id), INDEX IDX_D09A2751693EA4CA (certificacion_id), INDEX IDX_D09A275153C8D32C (propietario_id), INDEX IDX_D09A275124DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atributos_catacion (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_EB9712BAD17F50A6 (uuid), INDEX IDX_EB9712BA53C8D32C (propietario_id), INDEX IDX_EB9712BA24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE certificacion (id INT AUTO_INCREMENT NOT NULL, padre_id INT DEFAULT NULL, detalle_periodo_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, alias VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_A1F20253D17F50A6 (uuid), INDEX IDX_A1F20253613CEC58 (padre_id), INDEX IDX_A1F20253EAC40C8A (detalle_periodo_id), INDEX IDX_A1F2025353C8D32C (propietario_id), INDEX IDX_A1F2025324DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detalle_atributos (id INT AUTO_INCREMENT NOT NULL, atributo_catacion_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_37E9D312D17F50A6 (uuid), INDEX IDX_37E9D3129F49337E (atributo_catacion_id), INDEX IDX_37E9D31253C8D32C (propietario_id), INDEX IDX_37E9D31224DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detalle_periodo (id INT AUTO_INCREMENT NOT NULL, producto_id INT NOT NULL, periodo_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, acciones VARCHAR(30) NOT NULL, tara VARCHAR(15) NOT NULL, humedad_inicial VARCHAR(15) NOT NULL, muestra VARCHAR(15) NOT NULL, unidad_medida VARCHAR(10) NOT NULL, envase VARCHAR(10) NOT NULL, moneda VARCHAR(8) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_3BC82A45D17F50A6 (uuid), INDEX IDX_3BC82A457645698E (producto_id), INDEX IDX_3BC82A459C3921AB (periodo_id), INDEX IDX_3BC82A4553C8D32C (propietario_id), INDEX IDX_3BC82A4524DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE empresa (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, ruc VARCHAR(11) DEFAULT NULL, direccion VARCHAR(80) DEFAULT NULL, gmail VARCHAR(80) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_B8D75A50D17F50A6 (uuid), INDEX IDX_B8D75A5053C8D32C (propietario_id), INDEX IDX_B8D75A5024DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado_socio (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, descripcion VARCHAR(15) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_324DD5FBD17F50A6 (uuid), INDEX IDX_324DD5FB53C8D32C (propietario_id), INDEX IDX_324DD5FB24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periodo (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, alias VARCHAR(16) NOT NULL, descripcion LONGTEXT DEFAULT NULL, fecha_inicio DATE NOT NULL, fecha_final DATE NOT NULL, estado VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_7316C4EDD17F50A6 (uuid), INDEX IDX_7316C4ED53C8D32C (propietario_id), INDEX IDX_7316C4ED24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE periodo_producto (periodo_id INT NOT NULL, producto_id INT NOT NULL, INDEX IDX_3556BA9F9C3921AB (periodo_id), INDEX IDX_3556BA9F7645698E (producto_id), PRIMARY KEY(periodo_id, producto_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, alias VARCHAR(15) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_A7BB0615D17F50A6 (uuid), INDEX IDX_A7BB061553C8D32C (propietario_id), INDEX IDX_A7BB061524DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reporte_territorial (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(100) NOT NULL, codigo VARCHAR(6) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_644EC229D17F50A6 (uuid), INDEX IDX_644EC22953C8D32C (propietario_id), INDEX IDX_644EC22924DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE socio (id INT AUTO_INCREMENT NOT NULL, estado_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, fecha_ingreso DATE NOT NULL, codigo VARCHAR(16) NOT NULL, nombres VARCHAR(50) NOT NULL, apellido_paterno VARCHAR(30) NOT NULL, apellido_materno VARCHAR(30) NOT NULL, numero_documento VARCHAR(15) NOT NULL, telefono VARCHAR(9) NOT NULL, fecha_nacimiento DATE NOT NULL, conyugue_nombre VARCHAR(20) DEFAULT NULL, conyugue_documento VARCHAR(15) DEFAULT NULL, ruc VARCHAR(11) NOT NULL, tipo VARCHAR(15) NOT NULL, sexo VARCHAR(15) NOT NULL, estado_ruc VARCHAR(10) NOT NULL, foto VARCHAR(255) DEFAULT NULL, tipo_documento VARCHAR(30) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_38B65309D17F50A6 (uuid), INDEX IDX_38B653099F5A440B (estado_id), INDEX IDX_38B6530953C8D32C (propietario_id), INDEX IDX_38B6530924DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_almacen (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(80) NOT NULL, detalle VARCHAR(80) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_C64BF3F0D17F50A6 (uuid), INDEX IDX_C64BF3F053C8D32C (propietario_id), INDEX IDX_C64BF3F024DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unidad_equivalencia (id INT AUTO_INCREMENT NOT NULL, unidad_medida_id INT DEFAULT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, unidad VARCHAR(20) NOT NULL, valor_equivalencia INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_C4C222AFD17F50A6 (uuid), INDEX IDX_C4C222AF2E003F4 (unidad_medida_id), INDEX IDX_C4C222AF53C8D32C (propietario_id), INDEX IDX_C4C222AF24DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unidad_medida (id INT AUTO_INCREMENT NOT NULL, categoria_id INT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, simbolo VARCHAR(10) NOT NULL, alias VARCHAR(10) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_7DA31363D17F50A6 (uuid), INDEX IDX_7DA313633397707A (categoria_id), INDEX IDX_7DA3136353C8D32C (propietario_id), INDEX IDX_7DA3136324DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unidad_medida_categoria (id INT AUTO_INCREMENT NOT NULL, propietario_id INT DEFAULT NULL, config_id INT DEFAULT NULL, nombre VARCHAR(50) NOT NULL, alias VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, activo TINYINT(1) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_56C2373D17F50A6 (uuid), INDEX IDX_56C237353C8D32C (propietario_id), INDEX IDX_56C237324DB0683 (config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acopio (id INT AUTO_INCREMENT NOT NULL, periodo_id INT NOT NULL, socio_id INT NOT NULL, certificacion_id INT NOT NULL, almacen_id INT NOT NULL, fecha DATE NOT NULL, tikect VARCHAR(9) NOT NULL, peso_bruto INT NOT NULL, cantidad INT NOT NULL, tara_por_saco NUMERIC(10, 2) NOT NULL, tara_de_sacos NUMERIC(10, 2) NOT NULL, peso_quintales NUMERIC(10, 2) NOT NULL, peso_neto NUMERIC(10, 0) NOT NULL, observaciones LONGTEXT DEFAULT NULL, INDEX IDX_F27E53E39C3921AB (periodo_id), INDEX IDX_F27E53E3DA04E6A9 (socio_id), INDEX IDX_F27E53E3693EA4CA (certificacion_id), INDEX IDX_F27E53E39C9C9E68 (almacen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D250D1A9C40 FOREIGN KEY (tipo_almacen_id) REFERENCES tipo_almacen (id)');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D25057E759E8 FOREIGN KEY (ubicacion_id) REFERENCES reporte_territorial (id)');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D250521E1991 FOREIGN KEY (empresa_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D25053C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D25024DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE analisis_fisico ADD CONSTRAINT FK_43D689E8693EA4CA FOREIGN KEY (certificacion_id) REFERENCES certificacion (id)');
        $this->addSql('ALTER TABLE analisis_fisico ADD CONSTRAINT FK_43D689E853C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE analisis_fisico ADD CONSTRAINT FK_43D689E824DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE analisis_sensorial ADD CONSTRAINT FK_D09A27519C3921AB FOREIGN KEY (periodo_id) REFERENCES periodo (id)');
        $this->addSql('ALTER TABLE analisis_sensorial ADD CONSTRAINT FK_D09A2751693EA4CA FOREIGN KEY (certificacion_id) REFERENCES certificacion (id)');
        $this->addSql('ALTER TABLE analisis_sensorial ADD CONSTRAINT FK_D09A275153C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE analisis_sensorial ADD CONSTRAINT FK_D09A275124DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE atributos_catacion ADD CONSTRAINT FK_EB9712BA53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE atributos_catacion ADD CONSTRAINT FK_EB9712BA24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE certificacion ADD CONSTRAINT FK_A1F20253613CEC58 FOREIGN KEY (padre_id) REFERENCES certificacion (id)');
        $this->addSql('ALTER TABLE certificacion ADD CONSTRAINT FK_A1F20253EAC40C8A FOREIGN KEY (detalle_periodo_id) REFERENCES detalle_periodo (id)');
        $this->addSql('ALTER TABLE certificacion ADD CONSTRAINT FK_A1F2025353C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE certificacion ADD CONSTRAINT FK_A1F2025324DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE detalle_atributos ADD CONSTRAINT FK_37E9D3129F49337E FOREIGN KEY (atributo_catacion_id) REFERENCES atributos_catacion (id)');
        $this->addSql('ALTER TABLE detalle_atributos ADD CONSTRAINT FK_37E9D31253C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE detalle_atributos ADD CONSTRAINT FK_37E9D31224DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE detalle_periodo ADD CONSTRAINT FK_3BC82A457645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE detalle_periodo ADD CONSTRAINT FK_3BC82A459C3921AB FOREIGN KEY (periodo_id) REFERENCES periodo (id)');
        $this->addSql('ALTER TABLE detalle_periodo ADD CONSTRAINT FK_3BC82A4553C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE detalle_periodo ADD CONSTRAINT FK_3BC82A4524DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE empresa ADD CONSTRAINT FK_B8D75A5053C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE empresa ADD CONSTRAINT FK_B8D75A5024DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE estado_socio ADD CONSTRAINT FK_324DD5FB53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE estado_socio ADD CONSTRAINT FK_324DD5FB24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE periodo ADD CONSTRAINT FK_7316C4ED53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE periodo ADD CONSTRAINT FK_7316C4ED24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE periodo_producto ADD CONSTRAINT FK_3556BA9F9C3921AB FOREIGN KEY (periodo_id) REFERENCES periodo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE periodo_producto ADD CONSTRAINT FK_3556BA9F7645698E FOREIGN KEY (producto_id) REFERENCES producto (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB061553C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB061524DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE reporte_territorial ADD CONSTRAINT FK_644EC22953C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reporte_territorial ADD CONSTRAINT FK_644EC22924DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE socio ADD CONSTRAINT FK_38B653099F5A440B FOREIGN KEY (estado_id) REFERENCES estado_socio (id)');
        $this->addSql('ALTER TABLE socio ADD CONSTRAINT FK_38B6530953C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE socio ADD CONSTRAINT FK_38B6530924DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE tipo_almacen ADD CONSTRAINT FK_C64BF3F053C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE tipo_almacen ADD CONSTRAINT FK_C64BF3F024DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE unidad_equivalencia ADD CONSTRAINT FK_C4C222AF2E003F4 FOREIGN KEY (unidad_medida_id) REFERENCES unidad_medida (id)');
        $this->addSql('ALTER TABLE unidad_equivalencia ADD CONSTRAINT FK_C4C222AF53C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE unidad_equivalencia ADD CONSTRAINT FK_C4C222AF24DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE unidad_medida ADD CONSTRAINT FK_7DA313633397707A FOREIGN KEY (categoria_id) REFERENCES unidad_medida_categoria (id)');
        $this->addSql('ALTER TABLE unidad_medida ADD CONSTRAINT FK_7DA3136353C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE unidad_medida ADD CONSTRAINT FK_7DA3136324DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE unidad_medida_categoria ADD CONSTRAINT FK_56C237353C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE unidad_medida_categoria ADD CONSTRAINT FK_56C237324DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('ALTER TABLE acopio ADD propietario_id INT DEFAULT NULL, ADD config_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD activo TINYINT(1) NOT NULL, ADD uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E39C3921AB FOREIGN KEY (periodo_id) REFERENCES periodo (id)');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E3DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id)');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E3693EA4CA FOREIGN KEY (certificacion_id) REFERENCES certificacion (id)');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E39C9C9E68 FOREIGN KEY (almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E353C8D32C FOREIGN KEY (propietario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE acopio ADD CONSTRAINT FK_F27E53E324DB0683 FOREIGN KEY (config_id) REFERENCES config (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F27E53E3D17F50A6 ON acopio (uuid)');
        $this->addSql('CREATE INDEX IDX_F27E53E353C8D32C ON acopio (propietario_id)');
        $this->addSql('CREATE INDEX IDX_F27E53E324DB0683 ON acopio (config_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acopio DROP FOREIGN KEY FK_F27E53E39C9C9E68');
        $this->addSql('ALTER TABLE almacen DROP FOREIGN KEY FK_D5B2D250521E1991');
        $this->addSql('ALTER TABLE detalle_atributos DROP FOREIGN KEY FK_37E9D3129F49337E');
        $this->addSql('ALTER TABLE acopio DROP FOREIGN KEY FK_F27E53E3693EA4CA');
        $this->addSql('ALTER TABLE analisis_fisico DROP FOREIGN KEY FK_43D689E8693EA4CA');
        $this->addSql('ALTER TABLE analisis_sensorial DROP FOREIGN KEY FK_D09A2751693EA4CA');
        $this->addSql('ALTER TABLE certificacion DROP FOREIGN KEY FK_A1F20253613CEC58');
        $this->addSql('ALTER TABLE certificacion DROP FOREIGN KEY FK_A1F20253EAC40C8A');
        $this->addSql('ALTER TABLE socio DROP FOREIGN KEY FK_38B653099F5A440B');
        $this->addSql('ALTER TABLE acopio DROP FOREIGN KEY FK_F27E53E39C3921AB');
        $this->addSql('ALTER TABLE analisis_sensorial DROP FOREIGN KEY FK_D09A27519C3921AB');
        $this->addSql('ALTER TABLE detalle_periodo DROP FOREIGN KEY FK_3BC82A459C3921AB');
        $this->addSql('ALTER TABLE periodo_producto DROP FOREIGN KEY FK_3556BA9F9C3921AB');
        $this->addSql('ALTER TABLE detalle_periodo DROP FOREIGN KEY FK_3BC82A457645698E');
        $this->addSql('ALTER TABLE periodo_producto DROP FOREIGN KEY FK_3556BA9F7645698E');
        $this->addSql('ALTER TABLE almacen DROP FOREIGN KEY FK_D5B2D25057E759E8');
        $this->addSql('ALTER TABLE acopio DROP FOREIGN KEY FK_F27E53E3DA04E6A9');
        $this->addSql('ALTER TABLE almacen DROP FOREIGN KEY FK_D5B2D250D1A9C40');
        $this->addSql('ALTER TABLE unidad_equivalencia DROP FOREIGN KEY FK_C4C222AF2E003F4');
        $this->addSql('ALTER TABLE unidad_medida DROP FOREIGN KEY FK_7DA313633397707A');
        $this->addSql('DROP TABLE almacen');
        $this->addSql('DROP TABLE analisis_fisico');
        $this->addSql('DROP TABLE analisis_sensorial');
        $this->addSql('DROP TABLE atributos_catacion');
        $this->addSql('DROP TABLE certificacion');
        $this->addSql('DROP TABLE detalle_atributos');
        $this->addSql('DROP TABLE detalle_periodo');
        $this->addSql('DROP TABLE empresa');
        $this->addSql('DROP TABLE estado_socio');
        $this->addSql('DROP TABLE periodo');
        $this->addSql('DROP TABLE periodo_producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE reporte_territorial');
        $this->addSql('DROP TABLE socio');
        $this->addSql('DROP TABLE tipo_almacen');
        $this->addSql('DROP TABLE unidad_equivalencia');
        $this->addSql('DROP TABLE unidad_medida');
        $this->addSql('DROP TABLE unidad_medida_categoria');
        $this->addSql('ALTER TABLE acopio DROP FOREIGN KEY FK_F27E53E353C8D32C');
        $this->addSql('ALTER TABLE acopio DROP FOREIGN KEY FK_F27E53E324DB0683');
        $this->addSql('DROP INDEX UNIQ_F27E53E3D17F50A6 ON acopio');
        $this->addSql('DROP INDEX IDX_F27E53E353C8D32C ON acopio');
        $this->addSql('DROP INDEX IDX_F27E53E324DB0683 ON acopio');
        $this->addSql('ALTER TABLE acopio DROP propietario_id, DROP config_id, DROP created_at, DROP updated_at, DROP activo, DROP uuid');
    }
}
