<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707125625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE device (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, path_logo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, games_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_852BBECD97FFC673 (games_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, launch_at DATETIME NOT NULL, price INT NOT NULL, note_global INT NOT NULL, path_img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_device (game_id INT NOT NULL, device_id INT NOT NULL, INDEX IDX_741A1B46E48FD905 (game_id), INDEX IDX_741A1B4694A4C7D4 (device_id), PRIMARY KEY(game_id, device_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_game_category (game_id INT NOT NULL, game_category_id INT NOT NULL, INDEX IDX_7EC7A8CE48FD905 (game_id), INDEX IDX_7EC7A8CCC13DFE0 (game_category_id), PRIMARY KEY(game_id, game_category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, topics_id INT DEFAULT NULL, created_at DATETIME NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_B6BD307FBF06A414 (topics_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, post_category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, status INT NOT NULL, number_view INT NOT NULL, INDEX IDX_5A8A6C8DFE0617CD (post_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, forums_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, path_logo VARCHAR(255) NOT NULL, INDEX IDX_9D40DE1B618BA34B (forums_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forum ADD CONSTRAINT FK_852BBECD97FFC673 FOREIGN KEY (games_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_device ADD CONSTRAINT FK_741A1B46E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_device ADD CONSTRAINT FK_741A1B4694A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_category ADD CONSTRAINT FK_7EC7A8CE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_game_category ADD CONSTRAINT FK_7EC7A8CCC13DFE0 FOREIGN KEY (game_category_id) REFERENCES game_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FBF06A414 FOREIGN KEY (topics_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DFE0617CD FOREIGN KEY (post_category_id) REFERENCES post_category (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B618BA34B FOREIGN KEY (forums_id) REFERENCES forum (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_device DROP FOREIGN KEY FK_741A1B4694A4C7D4');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B618BA34B');
        $this->addSql('ALTER TABLE forum DROP FOREIGN KEY FK_852BBECD97FFC673');
        $this->addSql('ALTER TABLE game_device DROP FOREIGN KEY FK_741A1B46E48FD905');
        $this->addSql('ALTER TABLE game_game_category DROP FOREIGN KEY FK_7EC7A8CE48FD905');
        $this->addSql('ALTER TABLE game_game_category DROP FOREIGN KEY FK_7EC7A8CCC13DFE0');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DFE0617CD');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FBF06A414');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_device');
        $this->addSql('DROP TABLE game_game_category');
        $this->addSql('DROP TABLE game_category');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('DROP TABLE topic');
    }
}
