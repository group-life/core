<?php

declare(strict_types=1);

namespace GroupLife\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210923165030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create activity table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table activity
            (
                id integer not null
                    constraint activity_pk
                        primary key autoincrement,
                name text not null,
                schedule_id int
                    constraint activity_schedule_id_fk
                        references schedule (id),
                leader_id int
                    constraint activity_leader_id_fk
                        references leader (id)
            );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table activity');
    }
}
