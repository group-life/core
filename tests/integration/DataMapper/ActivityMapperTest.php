<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\DataMapper;

use GroupLife\Core\Activity;
use GroupLife\Core\DataMapper\ActivityMapper;
use GroupLife\Core\Test\TestCaseWithCoreClasses;

class ActivityMapperTest extends TestCaseWithCoreClasses
{
    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \GroupLife\Core\Exception\SavingToDbIsForbidden
     */
    public function testInsert()
    {
        $this->leaderMapper->insert($this->leader);
        $this->scheduleMapper->insert($this->schedule);
        $mapper = new ActivityMapper(self::$db);
        $mapper->insert($this->activity);
        $sqlQuery = '
            select
                   a.id as activity_id,
                   a.name as activity_name,
                   l.name as teacher_name,
                   l.surname as teacher_surname,
                   count(sr.type) as schedule_type,
                   count(sr.data) as schedule_rules
            from activity as a
                inner join leader l
                    on a.leader_id = l.id
                inner join schedule s on a.schedule_id = s.id
            inner join schedule_rule sr on s.id = sr.schedule_id
            where activity_id = ?
        ';
        self::assertEquals(
            [
                'activity_id' => (string)getDataObject($this->activity)->id,
                'activity_name' => 'Skiing',
                'teacher_name' => 'Ivan',
                'teacher_surname' => 'Teacher',
                'schedule_type' => '3',
                'schedule_rules' => '3'
            ],
            self::$db->fetchAssociative($sqlQuery, [getDataObject($this->activity)->id])
        );
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFind()
    {
        $mapper = new ActivityMapper(self::$db);
        $id = 1;
        $newActivity = $mapper->find($id, $this->leaderMapper, $this->scheduleMapper);
        self::assertInstanceOf(Activity::class, $newActivity);
        self::assertEquals($id, getDataObject($newActivity)->id);
    }
}
