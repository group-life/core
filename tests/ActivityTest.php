<?php

declare(strict_types=1);

namespace GroupLife\Core\tests;

use GroupLife\Core\Activity;
use GroupLife\Core\Schedule;
use GroupLife\Core\Subscription\Membership;
use GroupLife\Core\Visitor;
use PHPUnit\Framework\TestCase;

class ActivityTest extends TestCase
{

    public function testGetName()
    {
        $activity = new Activity('Skiing');
        $this->assertEquals('Skiing', $activity->getName());
    }

    public function testActivityVisits()
    {
        $activity = new Activity('Skiing');
        $rules = new Schedule\WeekdayRule('Sunday', '08:00');
        $schedule = new Schedule([$rules]);
        $activity->setSchedule($schedule->materialize(new \DateTime('2021-01-01'), new \DateInterval('P1M')));
        $visitor = new Visitor('Ivan', 'Pupkin');
        $subscription = new Membership(new \DateTime('2021-01-01'), new \DateInterval('P1M'));

        $this->assertCount(5, $activity->subscribe($visitor, $subscription));
    }
}
