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
        $dateFrom = new \DateTimeImmutable('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $scheduleDays = new Schedule([
            new Schedule\DayRule(new \DateTimeImmutable('2021-01-01 10:00')),
            new Schedule\CancelDayRule('2021-01-01', '10:00')
        ]);
        $this->assertEquals(
            [],
            $scheduleDays->materialize($dateFrom, $oneMonth)
        );
    }
}
