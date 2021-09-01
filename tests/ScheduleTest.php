<?php

declare(strict_types=1);

namespace GroupLife\Core\tests;

use PHPUnit\Framework\TestCase;
use GroupLife\Core\Schedule;

class ScheduleTest extends TestCase
{

    public function testMaterialize()
    {
        $dateFrom = new \DateTime('08:00 next Sunday', new \DateTimeZone('+0300'));
        $oneMonth = new \DateTime('08:00 + 1 month', new \DateTimeZone('+0300'));
        $dateInt   = new \DateInterval('PT1H');
        $schedule = new Schedule(
            new Schedule\Weekday('Tuesday', '10:00', new \DateInterval('PT1H')),
        );
        $dates = $schedule->materialize($dateFrom, $oneMonth);

        $this->assertIsArray($dates = $schedule->materialize($dateFrom, $oneMonth));
    }
}
