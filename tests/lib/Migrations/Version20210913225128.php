<?php

declare(strict_types=1);

namespace GroupLife\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210913225128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initialize DB';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE `activity` (
              id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
              `name` VARCHAR(255) NOT NULL,
              `schedule` INT NOT NULL,
              `leader` INT DEFAULT NULL,
              CONSTRAINT activity_leader_id_fk 
                  FOREIGN KEY (`leader`) REFERENCES leader(`id`),
              CONSTRAINT activity_schedule_id_fk 
                  FOREIGN KEY (`schedule`) REFERENCES schedule(`id`) 
              )');

        $this->addSql('CREATE TABLE `leader` (
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `surname` VARCHAR(255) NOT NULL)
        ');

        $this->addSql('CREATE TABLE `schedule` (
            id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)
        )');

        $this->addSql('CREATE TABLE `schedule_rule` (
          id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `rules` INT NOT NULL,
            `schedule`INT NOT NULL ,
            `type` INT NOT NULL,
            CONSTRAINT schedule_rule_schedule_id_fk 
                FOREIGN KEY (`schedule`) REFERENCES schedule(`id`),
            CONSTRAINT schedule_rule_schedule_type_id_fk 
                FOREIGN KEY (`type`) REFERENCES schedule_type(`id`)
        )');

        $this->addSql('CREATE TABLE `schedule_type` (
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL
        )');

        $this->addSql('CREATE TABLE `subscription` (
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            `type` INT NOT NULL,
            `time_from` DATETIME NOT NULL,
            `period` INT NOT NULL,
            `available` tinyint(1) DEFAULT NULL,
            `activity` INT DEFAULT NULL,
            `visitor` INT NOT NULL,
            CONSTRAINT subscription_subscription_type_id_fk 
                FOREIGN KEY (`type`) REFERENCES subscription_type(`id`),
            CONSTRAINT subscription_activity_id_fk 
                FOREIGN KEY (`activity`) REFERENCES activity(`id`),
            CONSTRAINT subscription_visitor_id_fk 
                FOREIGN KEY (`visitor`) REFERENCES visitor(`id`)
)');

        $this->addSql('CREATE TABLE `subscription_type` (
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL
        )');

        $this->addSql('CREATE TABLE `visitor` (
            id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `surname` VARCHAR(255) NOT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE leader');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE schedule_rule');
        $this->addSql('DROP TABLE schedule_type');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE subscription_type');
        $this->addSql('DROP TABLE visitor');
    }
}
