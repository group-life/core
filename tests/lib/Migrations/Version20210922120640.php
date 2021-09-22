<?php

declare(strict_types=1);

namespace GroupLife\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210922120640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create visitor table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table visitor
            (
                id integer not null constraint rule_pk primary key autoincrement,
                name text,
                surname text
            );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            drop table visitor;
        ');
    }
}
