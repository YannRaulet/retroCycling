<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210407071551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cycling_shirt ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE cycling_shirt ADD CONSTRAINT FK_CCAC09827E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CCAC09827E3C61F9 ON cycling_shirt (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cycling_shirt DROP FOREIGN KEY FK_CCAC09827E3C61F9');
        $this->addSql('DROP INDEX IDX_CCAC09827E3C61F9 ON cycling_shirt');
        $this->addSql('ALTER TABLE cycling_shirt DROP owner_id');
    }
}
