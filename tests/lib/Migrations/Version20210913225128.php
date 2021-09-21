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
        $this->addSql('
            create table schedule(
            id integer not null constraint rule_pk primary key autoincrement);');
        $this->addSql('
            create table schedule_rule
                (
                    id integer not null constraint schedule_rule_pk primary key autoincrement,
                    data text not null,
                    schedule int references schedule,
                    type text not null
                );');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table schedule');
        $this->addSql('drop table schedule_rule');

    }
}
