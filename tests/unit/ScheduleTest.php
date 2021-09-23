<?php

declare(strict_types=1);

namespace GroupLife\Core\tests;

use PHPUnit\Framework\TestCase;
use GroupLife\Core\Schedule;

class ScheduleTest extends TestCase
{
    public function testMaterializeWeekdayRule()
    {
        $dateFrom = new \DateTimeImmutable('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Tuesday', '10:00')
        ]);
        $this->assertEquals(
            [
                new \DateTimeImmutable('2021-01-05 10:00'),
                new \DateTimeImmutable('2021-01-12 10:00'),
                new \DateTimeImmutable('2021-01-19 10:00'),
                new \DateTimeImmutable('2021-01-26 10:00'),
            ],
            $schedule->materialize($dateFrom, $oneMonth)
        );
    }

    public function testMaterializeDayRule()
    {
        $dateFrom = new \DateTimeImmutable('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $scheduleDays = new Schedule([
            new Schedule\DayRule(new \DateTimeImmutable('2021-01-01 10:00'))
        ]);
        $this->assertEquals(
            [
                new \DateTimeImmutable('2021-01-01 10:00'),
            ],
            $scheduleDays->materialize($dateFrom, $oneMonth)
        );
    }

    public function testMaterializeCancelDayRule()
    {
        $scheduleDays = new Schedule([
            new Schedule\WeekdayRule('Monday', '10:00'),
            new Schedule\CancelDayRule('2021-01-11', '10:00'),
            new Schedule\CancelDayRule('2021-01-25', '10:00'),
        ]);

        $this->assertEquals(
            [
                new \DateTimeImmutable('2021-01-04 10:00'),
                new \DateTimeImmutable('2021-01-18 10:00'),
            ],
            $scheduleDays->materialize(
                new \DateTimeImmutable('2021-01-01'),
                new \DateInterval('P1M')
            )
        );
    }

    public function testGetData()
    {
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Monday', '10:00'),
            new Schedule\CancelDayRule('2021-01-11', '10:00'),
            new Schedule\CancelDayRule('2021-01-25', '10:00'),
        ]);

        $object1 = new \stdClass();
        $object1->type = 'GroupLife\Core\Schedule\WeekdayRule';
        $object1->data = '{"weekday":"Monday","startTime":"10:00"}';
        $object2 = new \stdClass();
        $object2->type = 'GroupLife\Core\Schedule\CancelDayRule';
        $object2->data = '{"day":"2021-01-11","time":"10:00"}';
        $object3 = new \stdClass();
        $object3->type = 'GroupLife\Core\Schedule\CancelDayRule';
        $object3->data = '{"day":"2021-01-25","time":"10:00"}';

        $this->assertEquals([
            $object1,
            $object2,
            $object3
        ], json_decode(json_encode($schedule))->rules);
    }
}
