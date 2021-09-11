<?php

declare(strict_types=1);

namespace GroupLife\Core\tests;

use GroupLife\Core\Activity;
use GroupLife\Core\Leader;
use GroupLife\Core\Schedule;
use GroupLife\Core\Subscription\Membership;
use GroupLife\Core\Subscription\OneTime;
use GroupLife\Core\Visitor;
use PHPUnit\Framework\TestCase;

class ActivityTest extends TestCase
{
    public function testGetName()
    {
        $this->assertEquals('Skiing', self::skiing()->getName());
    }

    public function testCanSubscribeHavingMembershipSubscription()
    {
        $visitor = new Visitor('Ivan', 'Pupkin');
        $subscription = new Membership(new \DateTimeImmutable('2021-01-01'), new \DateInterval('P1M'));
        $this->assertCount(4, self::skiing()->subscribe($visitor, $subscription));
    }

    public function testCanSubscribeHavingOneTimeSubscription()
    {
        $visitor = new Visitor('Ivan', 'Pupkin');
        $subscription = new OneTime(new \DateTimeImmutable('2021-09-06'), new \DateInterval('P1W'));
        $visits = self::skiing()->subscribe($visitor, $subscription);
        $this->assertCount(1, $visits);
    }

    public function testCanSubscribeHavingActivitySubscription()
    {
        $visitor = new Visitor('Ivan', 'Pupkin');
        $subscription = new \GroupLife\Core\Subscription\Activity(
            new \DateTimeImmutable('2021-09-06'),
            new \DateInterval('P1W'),
            self::skiing()
        );
        $visits = self::chess()->subscribe($visitor, $subscription);
        $this->assertCount(0, $visits);
    }

    /**
     * @return Activity
     */
    private static function skiing(): Activity
    {
        $leader = new Leader('Ivan', 'Ivanov');
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Tuesday', '10:00')
        ]);

        return new Activity('Skiing', $schedule, $leader);
    }

    /**
     * @return Activity
     */
    private static function chess(): Activity
    {
        $leader = new Leader('Petr', 'Petrov');
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Monday', '09:00')
        ]);

        return new Activity('Chess', $schedule, $leader);
    }
}
