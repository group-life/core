<?php

declare(strict_types=1);

namespace GroupLife\Core\Test\DataMapper;

use GroupLife\Core\DataMapper\LeaderMapper;
use GroupLife\Core\Leader;
use GroupLife\Core\Test\TestCaseWithDb;

class LeaderMapperTest extends TestCaseWithDb
{
    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testInsert()
    {
        $leader = new Leader('Petr', 'Petrov');
        $mapper = new LeaderMapper(self::$db);
        $mapper->insert($leader);
        $leaderId = getDataObject($leader)->id;
        self::assertEquals(
            [
                'id' => (string)$leaderId,
                'name' => 'Petr',
                'surname' => 'Petrov'
            ],
            self::$db->fetchAssociative('SELECT * FROM `leader` WHERE id = ?', [$leaderId])
        );
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFind()
    {
        $mapper = new LeaderMapper(self::$db);
        $newLeader = $mapper->find(1);
        self::assertInstanceOf(Leader::class, $newLeader);
    }

    /**
     * @param $leader
     */
    public function testUpdate()
    {
        $mapper = new LeaderMapper(self::$db);
        $newLeader = $mapper->find(1);
        $newLeader->setName('Vasiliy');
        $newLeader->setSurname('Chapaev');
        $mapper->update($newLeader);
        self::assertEquals(
            [
                'id' => '1',
                'name' => 'Vasiliy',
                'surname' => 'Chapaev'
            ],
            self::$db->fetchAssociative('SELECT * FROM `leader` WHERE id = 1')
        );
    }

    public function testDelete()
    {
        $mapper = new LeaderMapper(self::$db);
        $newLeader = $mapper->delete(1);
        self::assertEquals(
            [],
            self::$db->fetchAssociative('SELECT * FROM `leader` WHERE id = 1')
        );
    }
}
