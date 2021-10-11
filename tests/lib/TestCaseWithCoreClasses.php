<?php

declare(strict_types=1);

namespace GroupLife\Core\Test;

use GroupLife\Core\Activity;
use GroupLife\Core\DataMapper\ActivityMapper;
use GroupLife\Core\DataMapper\LeaderMapper;
use GroupLife\Core\DataMapper\ScheduleMapper;
use GroupLife\Core\DataMapper\SubscriptionMapper;
use GroupLife\Core\DataMapper\VisitMapper;
use GroupLife\Core\DataMapper\VisitorMapper;
use GroupLife\Core\Leader;
use GroupLife\Core\Schedule;
use GroupLife\Core\Subscription\Membership;
use GroupLife\Core\Visitor;

class TestCaseWithCoreClasses extends TestCaseWithDb
{
    protected $schedule;
    protected $leader;
    protected $activity;
    protected $visitor;
    protected $subscription;
    protected $scheduleMapper;
    protected $leaderMapper;
    protected $visitorMapper;
    protected $activityMapper;
    protected $subscriptionMapper;
    protected $visitMapper;

    protected function setUp(): void
    {
        $this->schedule = new Schedule(
            [
                new Schedule\WeekdayRule('Monday', '10:00'),
                new Schedule\CancelDayRule('2021-01-11', '10:00'),
                new Schedule\CancelDayRule('2021-01-25', '10:00')
            ]
        );
        $this->leader = new Leader('Ivan', 'Teacher');
        $this->activity = new Activity('Skiing', $this->schedule, $this->leader);
        $this->visitor = new Visitor('Petr', 'Student');
        $this->subscription = new Membership(
            new \DateTimeImmutable('2021-01-01'),
            new \DateInterval('P1M'),
            $this->visitor
        );
        $this->scheduleMapper = new ScheduleMapper(self::$db);
        $this->leaderMapper = new LeaderMapper(self::$db);
        $this->visitorMapper = new VisitorMapper(self::$db);
        $this->activityMapper = new ActivityMapper(self::$db);
        $this->subscriptionMapper = new SubscriptionMapper(self::$db);
        $this->visitMapper = new VisitMapper(self::$db);
    }
}
