<?php

declare(strict_types=1);

namespace GroupLife\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211004203708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Alter columns activity and visitor in subscription table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('drop table subscription;');
        $this->addSql('
            create table subscription(
                id integer not null
                    constraint subscription_pk
                        primary key autoincrement,
                activity_id int default null
                    constraint subscription_activity_id_fk
                        references activity,
                visitor_id int not null
                    constraint subscription_visitor_id_fk
                        references visitor,
                type text not null,
                time_from datetime not null,
                period text not null,
                available tinyint default 1 not null);
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table subscription;');
        $this->addSql('
            create table subscription(
                id integer not null
                    constraint subscription_pk
                        primary key autoincrement,
                activity int default null
                    constraint subscription_activity_id_fk
                        references activity,
                visitor int not null
                    constraint subscription_visitor_id_fk
                        references visitor,
                type text not null,
                time_from datetime not null,
                period text not null,
                available tinyint default 1 not null);
        ');
    }
}
