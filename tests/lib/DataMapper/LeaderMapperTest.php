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
        self::assertEquals(
            [
                [
                    'id' => '1',
                    'name' => 'Petr',
                    'surname' => 'Petrov'
                ]
            ],
            self::$db->fetchAllAssociative('SELECT * FROM `leader` WHERE id = 1')
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
}
