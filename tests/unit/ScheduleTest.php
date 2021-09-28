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

    public function testJsonSerialize()
    {
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Monday', '10:00'),
            new Schedule\CancelDayRule('2021-01-11', '10:00'),
            new Schedule\CancelDayRule('2021-01-25', '10:00'),
        ]);
        $object = new \stdClass();
        $object->id = null;
        $object->rules = [];

        $rule1 = new \stdClass();
        $rule1->type = 'GroupLife\Core\Schedule\WeekdayRule';
        $rule1->data = '{"weekday":"Monday","startTime":"10:00"}';

        $rule2 = new \stdClass();
        $rule2->type = 'GroupLife\Core\Schedule\CancelDayRule';
        $rule2->data = '{"day":"2021-01-11","time":"10:00"}';

        $rule3 = new \stdClass();
        $rule3->type = 'GroupLife\Core\Schedule\CancelDayRule';
        $rule3->data = '{"day":"2021-01-25","time":"10:00"}';

        $object->rules = [
            $rule1,
            $rule2,
            $rule3
        ];
        $this->assertEquals($object, getDataObject($schedule));
    }
}
