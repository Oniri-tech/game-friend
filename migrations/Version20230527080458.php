<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527080458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `game_table` (id INT AUTO_INCREMENT NOT NULL, master_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C41AF6C913B3DB11 (master_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_user (table_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C7459682ECFF285C (table_id), INDEX IDX_C7459682A76ED395 (user_id), PRIMARY KEY(table_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(30) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `game_table` ADD CONSTRAINT FK_C41AF6C913B3DB11 FOREIGN KEY (master_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE table_user ADD CONSTRAINT FK_C7459682ECFF285C FOREIGN KEY (table_id) REFERENCES `game_table` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE table_user ADD CONSTRAINT FK_C7459682A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `game_table` DROP FOREIGN KEY FK_C41AF6C913B3DB11');
        $this->addSql('ALTER TABLE table_user DROP FOREIGN KEY FK_C7459682ECFF285C');
        $this->addSql('ALTER TABLE table_user DROP FOREIGN KEY FK_C7459682A76ED395');
        $this->addSql('DROP TABLE `game_table`');
        $this->addSql('DROP TABLE table_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
