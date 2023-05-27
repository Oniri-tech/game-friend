<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527135448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `game_character` (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT NULL, game_table_id INT NOT NULL, name VARCHAR(60) NOT NULL, npc TINYINT(1) NOT NULL, ethnicity VARCHAR(255) NOT NULL, culture VARCHAR(50) NOT NULL, character_class VARCHAR(20) NOT NULL, INDEX IDX_41DC713699E6F5DF (player_id), INDEX IDX_41DC713647BBD77A (game_table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `game_character` ADD CONSTRAINT FK_41DC713699E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `game_character` ADD CONSTRAINT FK_41DC713647BBD77A FOREIGN KEY (game_table_id) REFERENCES `game_table` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `game_character` DROP FOREIGN KEY FK_41DC713699E6F5DF');
        $this->addSql('ALTER TABLE `game_character` DROP FOREIGN KEY FK_41DC713647BBD77A');
        $this->addSql('DROP TABLE `game_character`');
    }
}
