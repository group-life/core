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
        $this->addSql('CREATE TABLE `schedule` (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('
            CREATE TABLE `schedule_rule` (
                id INT AUTO_INCREMENT NOT NULL, 
                rules TEXT, 
                schedule INT FOREIGNKEY schedule_rule_schedule_id_fk 
                    REFERENCES `schedule`(`id`) ON DELETE CASCADE ON UPDATE RESTRICT, 
                PRIMARY KEY(id))
                ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE rule');
    }
}
