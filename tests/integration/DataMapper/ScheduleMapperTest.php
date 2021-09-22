<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\DataMapper;

use GroupLife\Core\DataMapper\ScheduleMapper;
use GroupLife\Core\Schedule;
use GroupLife\Core\Test\TestCaseWithDb;

class ScheduleMapperTest extends TestCaseWithDb
{
    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function testInsert()
    {
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Monday', '10:00'),
            new Schedule\CancelDayRule('2021-01-11', '10:00'),
            new Schedule\CancelDayRule('2021-01-25', '10:00'),
        ]);
        $mapper = new ScheduleMapper(self::$db);
        $mapper->insert($schedule);
        $sqlQuery = '
            SELECT sr.type, sr.data, sr.schedule 
            FROM schedule s 
            INNER JOIN schedule_rule sr ON s.id = sr.schedule 
            WHERE s.id = 1 
            ORDER BY s.id';

        $this->assertEquals(
            [
                [
                    'type' => 'GroupLife\\Core\\Schedule\\WeekdayRule',
                    'data' => '{"weekday":"Monday","startTime":"10:00"}',
                    'schedule' => '1'

                ],
                [
                    'type' => 'GroupLife\\Core\\Schedule\\CancelDayRule',
                    'data' => '{"day":"2021-01-11","time":"10:00"}',
                    'schedule' => '1'
                ],
                [
                    'type' => 'GroupLife\\Core\\Schedule\\CancelDayRule',
                    'data' => '{"day":"2021-01-25","time":"10:00"}',
                    'schedule' => '1'
                ]
            ],
            self::$db->fetchAllAssociative($sqlQuery)
        );
    }
    public function testFind()
    {
        $mapper = new ScheduleMapper(self::$db);
        $newSchedule = $mapper->find(1);
        self::assertInstanceOf(Schedule::class, $newSchedule);
    }
}
