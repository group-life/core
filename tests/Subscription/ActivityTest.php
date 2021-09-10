<?php

declare(strict_types=1);

namespace GroupLife\Core\tests\Subscription;

use GroupLife\Core;
use GroupLife\Core\Leader;
use GroupLife\Core\Subscription;
use PHPUnit\Framework\TestCase;

class ActivityTest extends TestCase
{
    public function testScheduleActivityGetFunctions()
    {
        $leader = new Leader('Ivan', 'Ivanov');
        $schedule = new Core\Schedule([new Core\Schedule\WeekdayRule('Sunday', '10:00')]);
        $activity = new Core\Activity('Chess', $schedule, $leader);
        $purchase = new Subscription\Activity(
            new \DateTime('2021-01-01'),
            new \DateInterval('P1M'),
            $activity
        );
        $this->assertEquals(new \DateTime('2021-01-01'), $purchase->getStartDay());
        $this->assertEquals(new \DateInterval('P1M'), $purchase->getPeriod());
    }
}
