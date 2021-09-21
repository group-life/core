<?php

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Schedule;
use GroupLife\Core\Test\TestCaseWithDb;

class ScheduleMapperTest extends TestCaseWithDb
{
    public function testInsert()
    {
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Monday', '10:00'),
            new Schedule\CancelDayRule('2021-01-11', '10:00'),
            new Schedule\CancelDayRule('2021-01-25', '10:00'),
        ]);
        $mapper = new ScheduleMapper(self::$db);
        $mapper->insert($schedule);
        $sqlQuery = self::$db->createQueryBuilder();
        $sqlQuery
            ->select('*')
            ->from('schedule', 's')
            ->join('s', 'schedule_rule', 'sr', 's.id = sr.schedule')
            ->where('s.id = 1')
            ->orderBy('s.id');

        $this->assertEquals(
            [
                1 => [
                    'type' => 'GroupLife\\Core\\Schedule\\WeekdayRule',
                    'data' => '{"weekday":"Monday","startTime":"10:00"}',
                    'schedule' => '1'

                ],
                2 => [
                    'type' => 'GroupLife\\Core\\Schedule\\CancelDayRule',
                    'data' => '{"day":"2021-01-11","time":"10:00"}',
                    'schedule' => '1'
                ],
                3 => [
                    'type' => 'GroupLife\\Core\\Schedule\\CancelDayRule',
                    'data' => '{"day":"2021-01-25","time":"10:00"}',
                    'schedule' => '1'
                ]
            ],
            $sqlQuery->execute()->fetchAllAssociativeIndexed()
        );
    }
}
