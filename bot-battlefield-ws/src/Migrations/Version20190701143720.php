<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190701143720 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE opponent (id INT AUTO_INCREMENT NOT NULL, player_one_id INT NOT NULL, player_two_id INT NOT NULL, UNIQUE INDEX UNIQ_A9322AFF649A58CD (player_one_id), UNIQUE INDEX UNIQ_A9322AFFFC6BF02 (player_two_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE opponent ADD CONSTRAINT FK_A9322AFF649A58CD FOREIGN KEY (player_one_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE opponent ADD CONSTRAINT FK_A9322AFFFC6BF02 FOREIGN KEY (player_two_id) REFERENCES player (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE opponent');
    }
}
