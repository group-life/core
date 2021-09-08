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

    public function testGetName(): Activity
    {
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Tuesday', '10:00')
        ]);
        $activity = new Activity('Skiing', $schedule);
        $this->assertEquals('Skiing', $activity->getName());
        return $activity;
    }

    /**
     * @depends testGetName
     */
    public function testActivityVisits($activity)
    {
        $visitor = new Visitor('Ivan', 'Pupkin');
        $subscription = new Membership(new \DateTime('2021-01-01'), new \DateInterval('P1M'));
        $this->assertCount(4, $activity->subscribe($visitor, $subscription));
    }
}
