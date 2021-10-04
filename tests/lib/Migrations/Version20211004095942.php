<?php

declare(strict_types=1);

namespace GroupLife\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211004095942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Activity/Visits table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            create table visit(
                id integer not null
                    constraint visit_pk
                        primary key autoincrement,
                activity int not null
                    constraint visit_activity_id_fk
                        references activity,
                visitor int not null
                    constraint visit_visitor_id_fk
                        references visitor,
                time datetime not null,
                status text not null)
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('drop table visit');
    }
}
