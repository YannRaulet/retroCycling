<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401103936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_cycling_shirt (user_id INT NOT NULL, cycling_shirt_id INT NOT NULL, INDEX IDX_2222A4D2A76ED395 (user_id), INDEX IDX_2222A4D28A525E98 (cycling_shirt_id), PRIMARY KEY(user_id, cycling_shirt_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_cycling_shirt ADD CONSTRAINT FK_2222A4D2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_cycling_shirt ADD CONSTRAINT FK_2222A4D28A525E98 FOREIGN KEY (cycling_shirt_id) REFERENCES cycling_shirt (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_cycling_shirt');
    }
}
