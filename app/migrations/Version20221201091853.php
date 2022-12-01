<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221201091853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characters (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, origin_id INT DEFAULT NULL, location_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT NULL, species VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3A29410E3DA5256D (image_id), INDEX IDX_3A29410E56A273CC (origin_id), INDEX IDX_3A29410E64D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episodes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, aired_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', season_number INT NOT NULL, episode_number INT NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episode_character (episode_id INT NOT NULL, character_id INT NOT NULL, INDEX IDX_2DB8260D362B62A0 (episode_id), INDEX IDX_2DB8260D1136BE75 (character_id), PRIMARY KEY(episode_id, character_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, provider VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E01FBE6A93CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, dimension VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE watched_episodes (id INT AUTO_INCREMENT NOT NULL, episode_id INT DEFAULT NULL, user_id INT DEFAULT NULL, rating VARCHAR(255) NOT NULL, INDEX IDX_17D69F69362B62A0 (episode_id), INDEX IDX_17D69F69A76ED395 (user_id), UNIQUE INDEX UNIQ_17D69F69A76ED395362B62A0 (user_id, episode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E3DA5256D FOREIGN KEY (image_id) REFERENCES files (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E56A273CC FOREIGN KEY (origin_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE episode_character ADD CONSTRAINT FK_2DB8260D362B62A0 FOREIGN KEY (episode_id) REFERENCES episodes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE episode_character ADD CONSTRAINT FK_2DB8260D1136BE75 FOREIGN KEY (character_id) REFERENCES characters (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A93CB796C FOREIGN KEY (file_id) REFERENCES files (id)');
        $this->addSql('ALTER TABLE watched_episodes ADD CONSTRAINT FK_17D69F69362B62A0 FOREIGN KEY (episode_id) REFERENCES episodes (id)');
        $this->addSql('ALTER TABLE watched_episodes ADD CONSTRAINT FK_17D69F69A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410E3DA5256D');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410E56A273CC');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410E64D218E');
        $this->addSql('ALTER TABLE episode_character DROP FOREIGN KEY FK_2DB8260D362B62A0');
        $this->addSql('ALTER TABLE episode_character DROP FOREIGN KEY FK_2DB8260D1136BE75');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A93CB796C');
        $this->addSql('ALTER TABLE watched_episodes DROP FOREIGN KEY FK_17D69F69362B62A0');
        $this->addSql('ALTER TABLE watched_episodes DROP FOREIGN KEY FK_17D69F69A76ED395');
        $this->addSql('DROP TABLE characters');
        $this->addSql('DROP TABLE episodes');
        $this->addSql('DROP TABLE episode_character');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE watched_episodes');
    }
}
