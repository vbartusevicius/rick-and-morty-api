<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221201171713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE episode_location (episode_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_9718A0B9362B62A0 (episode_id), INDEX IDX_9718A0B964D218E (location_id), PRIMARY KEY(episode_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE episode_location ADD CONSTRAINT FK_9718A0B9362B62A0 FOREIGN KEY (episode_id) REFERENCES episodes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE episode_location ADD CONSTRAINT FK_9718A0B964D218E FOREIGN KEY (location_id) REFERENCES locations (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE episode_location DROP FOREIGN KEY FK_9718A0B9362B62A0');
        $this->addSql('ALTER TABLE episode_location DROP FOREIGN KEY FK_9718A0B964D218E');
        $this->addSql('DROP TABLE episode_location');
    }
}
