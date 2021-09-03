<?php

declare(strict_types=1);

namespace GroupLife\Core\tests;

use PHPUnit\Framework\TestCase;
use GroupLife\Core\Schedule;

class ScheduleTest extends TestCase
{
    public function testMaterializeWeekdayRule()
    {
        $dateFrom = new \DateTime('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Tuesday', '10:00')
        ]);
        $this->assertEquals(
            [
                new \DateTime('2021-01-05 10:00'),
                new \DateTime('2021-01-12 10:00'),
                new \DateTime('2021-01-19 10:00'),
                new \DateTime('2021-01-26 10:00'),
            ],
            $schedule->materialize($dateFrom, $oneMonth)
        );
    }

    public function testMaterializeDayRule()
    {
        $dateFrom = new \DateTime('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $scheduleDays = new Schedule([
            new Schedule\DayRule(['2021-01-01' => '10:00', '2021-01-02' => '09:00'])
        ]);
        $this->assertEquals(
            [
                new \DateTime('2021-01-01 10:00'),
                new \DateTime('2021-01-02 09:00'),
            ],
            $scheduleDays->materialize($dateFrom, $oneMonth)
        );
    }

    public function testMaterializeCancelDayRule()
    {
        $dateFrom = new \DateTime('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $scheduleDays = new Schedule([
            new Schedule\DayRule(['2021-01-01' => '10:00', '2021-01-02' => '09:00'])
        ]);
        $scheduleDays->materialize($dateFrom, $oneMonth);

        $dateCancelFrom = new \DateTime('2021-01-01');
        $scheduleDays->setRules([
            new Schedule\CancelDayRule(['2021-01-01' => '10:00'])
        ]);
        $this->assertEquals(
            [
                new \DateTime('2021-01-02 09:00'),
            ],
            $scheduleDays->materialize($dateCancelFrom, $oneMonth)
        );
    }
}