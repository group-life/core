<?php

declare(strict_types=1);

namespace GroupLife\Core\tests;

use PHPUnit\Framework\TestCase;
use GroupLife\Core\Schedule;

class ScheduleTest extends TestCase
{
    public function testMaterialize()
    {
        $this->markTestIncomplete('TODO');

        $dateFrom = new \DateTime('2021-01-01');
        $oneMonth = new \DateInterval('P1M');
        $schedule = new Schedule([
            // TODO: Tuesdays 10:00
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
}
