<?php

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Schedule;
use PHPUnit\Framework\TestCase;

class ScheduleMapperTest extends TestCase
{
    public function testInsert()
    {
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Monday', '10:00'),
            new Schedule\CancelDayRule('2021-01-11', '10:00'),
            new Schedule\CancelDayRule('2021-01-25', '10:00'),
        ]);
        $pdo = new \PDO('sqlite:../test.db');
        $mapper = new ScheduleMapper($pdo);
        $mapper->insert($schedule);
        $this->assertEquals(
            [
                [
                    'type' => 'GroupLife\\Core\\Schedule\\WeekdayRule',
                    'data' => '{"weekday":"Monday","startTime":"10:00"}',
                    'id' => '1',
                    'schedule' => '1'

                ],
                [
                    'type' => 'GroupLife\\Core\\Schedule\\CancelDayRule',
                    'data' => '{"day":"2021-01-11","time":"10:00"}',
                    'id' => '2',
                    'schedule' => '1'
                ],
                [
                    'type' => 'GroupLife\\Core\\Schedule\\CancelDayRule',
                    'data' => '{"day":"2021-01-25","time":"10:00"}',
                    'id' => '3',
                    'schedule' => '1'
                ]
            ],
            $pdo->query('SELECT * FROM schedule JOIN schedule_rule sr ON schedule.id = sr.schedule WHERE schedule.id=1 ORDER BY id')->fetchAll(\PDO::FETCH_ASSOC)
        );
    }
    public function testFind() {
        $pdo = new \PDO('sqlite:../test.db');
        $mapper = new ScheduleMapper($pdo);
        $newSchedule = $mapper->find(1);
        self::assertInstanceOf(Schedule::class, $newSchedule);
    }
}
