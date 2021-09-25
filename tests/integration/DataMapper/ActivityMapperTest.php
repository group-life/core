<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\DataMapper;

use GroupLife\Core\Activity;
use GroupLife\Core\DataMapper\ActivityMapper;
use GroupLife\Core\DataMapper\LeaderMapper;
use GroupLife\Core\DataMapper\ScheduleMapper;
use GroupLife\Core\Leader;
use GroupLife\Core\Schedule;
use GroupLife\Core\Test\TestCaseWithDb;

class ActivityMapperTest extends TestCaseWithDb
{

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testInsert()
    {
        $leader = new Leader('Petr', 'Petrov');
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Monday', '10:00'),
            new Schedule\CancelDayRule('2021-01-11', '10:00'),
            new Schedule\CancelDayRule('2021-01-25', '10:00'),
        ]);
        $activity = new Activity('Chess', $schedule, $leader);
        $mapper = new ActivityMapper(self::$db, new ScheduleMapper(self::$db), new LeaderMapper(self::$db));
        $mapper->insert($activity);
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
                'activity_id' => (string)$activity->getData()->id,
                'activity_name' => 'Chess',
                'teacher_name' => 'Petr',
                'teacher_surname' => 'Petrov',
                'schedule_type' => '3',
                'schedule_rules' => '3'
            ],
            self::$db->fetchAssociative($sqlQuery, [$activity->getData()->id])
        );
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function testFind()
    {
        $mapper = new ActivityMapper(self::$db, new ScheduleMapper(self::$db), new LeaderMapper(self::$db));
        $id = 1;
        $newActivity = $mapper->find($id);
        self::assertInstanceOf(Activity::class, $newActivity);
        self::assertEquals($id, $newActivity->getData()->id);
    }
}
