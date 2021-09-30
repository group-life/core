<?php

declare(strict_types=1);

namespace GroupLife\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210928131825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create subscription table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table subscription
            (
                id integer not null
                    constraint subscription_pk
                        primary key autoincrement,
                activity int default null
                    constraint subscription_activity_id_fk
                        references activity (id),
                visitor int not null
                    constraint subscription_visitor_id_pk
                        references visitor (id),
                type text not null,
                time_from datetime not null,
                period int not null,
                available tinyint not null default (1)
            );
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'drop table subscription'
        );
    }
}
