<?php

namespace GroupLife\Core\tests;

use PHPUnit\Framework\TestCase;
use GroupLife\Core\Schedule;

class ScheduleTest extends TestCase
{

    public function testMaterialize()
    {
        $from = new \DateTime('8:00', new \DateTimeZone( '+0300' ));
        $to = new \DateTime('8:00 +7 days', new \DateTimeZone( '+0300' ));


        $schedule = new Schedule($from, $to);
        $this->assertIsArray($schedule::$schedule);
    }
}
