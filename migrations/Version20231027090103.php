<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231027090103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clientes (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maquinas (id INT AUTO_INCREMENT NOT NULL, cliente_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_43CCB84ADE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maquinas_videos (maquinas_id INT NOT NULL, videos_id INT NOT NULL, INDEX IDX_633FCA97A582674E (maquinas_id), INDEX IDX_633FCA97763C10B2 (videos_id), PRIMARY KEY(maquinas_id, videos_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recaudaciones (id INT AUTO_INCREMENT NOT NULL, maquina_id INT DEFAULT NULL, fecha DATE NOT NULL, cantidad DOUBLE PRECISION NOT NULL, INDEX IDX_BBA2B27B41420729 (maquina_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videos (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, duracion INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE maquinas ADD CONSTRAINT FK_43CCB84ADE734E51 FOREIGN KEY (cliente_id) REFERENCES clientes (id)');
        $this->addSql('ALTER TABLE maquinas_videos ADD CONSTRAINT FK_633FCA97A582674E FOREIGN KEY (maquinas_id) REFERENCES maquinas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maquinas_videos ADD CONSTRAINT FK_633FCA97763C10B2 FOREIGN KEY (videos_id) REFERENCES videos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recaudaciones ADD CONSTRAINT FK_BBA2B27B41420729 FOREIGN KEY (maquina_id) REFERENCES maquinas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maquinas DROP FOREIGN KEY FK_43CCB84ADE734E51');
        $this->addSql('ALTER TABLE maquinas_videos DROP FOREIGN KEY FK_633FCA97A582674E');
        $this->addSql('ALTER TABLE maquinas_videos DROP FOREIGN KEY FK_633FCA97763C10B2');
        $this->addSql('ALTER TABLE recaudaciones DROP FOREIGN KEY FK_BBA2B27B41420729');
        $this->addSql('DROP TABLE clientes');
        $this->addSql('DROP TABLE maquinas');
        $this->addSql('DROP TABLE maquinas_videos');
        $this->addSql('DROP TABLE recaudaciones');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE videos');
    }
}
