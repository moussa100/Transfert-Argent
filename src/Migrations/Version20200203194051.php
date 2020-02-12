<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200203194051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE compte ADD partenaire VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE depot ADD no_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC1A65C546 FOREIGN KEY (no_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_47948BBC1A65C546 ON depot (no_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE compte DROP partenaire');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC1A65C546');
        $this->addSql('DROP INDEX IDX_47948BBC1A65C546 ON depot');
        $this->addSql('ALTER TABLE depot DROP no_id');
    }
}
