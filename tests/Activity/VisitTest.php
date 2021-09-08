<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Activity;

use GroupLife\Core\Activity;
use GroupLife\Core\Schedule;
use GroupLife\Core\Visitor;
use PHPUnit\Framework\TestCase;
use GroupLife\Core\Activity\Visit;

class VisitTest extends TestCase
{
    public function testCanBeConstructed()
    {
        $schedule = new Schedule([
            new Schedule\DayRule('2021-01-01', '10:00')
        ]);
        $visit = new Visit(
            new \DateTime('2021-01-01 10:00'),
            new Activity('Swimming', $schedule),
            new Visitor('Ivan', 'Pupkin')
        );
        $this->assertIsObject($visit);
    }
}
