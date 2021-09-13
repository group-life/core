<?php

declare(strict_types=1);

namespace GroupLife\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210913225128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initialize DB';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `schedules` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('
            CREATE TABLE `rules` (
                id INT AUTO_INCREMENT NOT NULL, 
                rules VARCHAR(255), 
                schedule INT, 
                PRIMARY KEY(id))
                ');
        $this->addSql('
            ALTER TABLE `rules` ADD FOREIGNKEY schedule 
            REFERENCES `schedules`(`id`) 
            ON DELETE CASCADE ON UPDATE RESTRICT;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE schedules');
        $this->addSql('DROP TABLE rules');
    }
}
