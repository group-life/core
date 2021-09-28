<?php

namespace GroupLife\Core\tests\DataMapper;

use GroupLife\Core\Activity;
use GroupLife\Core\DataMapper\ActivityMapper;
use GroupLife\Core\DataMapper\LeaderMapper;
use GroupLife\Core\DataMapper\ScheduleMapper;
use GroupLife\Core\DataMapper\SubscriptionMapper;
use GroupLife\Core\DataMapper\VisitorMapper;
use GroupLife\Core\Leader;
use GroupLife\Core\Schedule;
use GroupLife\Core\Test\TestCaseWithDb;
use GroupLife\Core\Visitor;

class SubscriptionMapperTest extends TestCaseWithDb
{

    public function testFind()
    {
        //Todo
    }

    public function testInsert()
    {
        $startTime = new \DateTimeImmutable('2021-01-01');
        $period = new \DateInterval('P1M');
        $visitor = new Visitor('Ivan', 'Ivanov');
        $leader = new Leader('Petr', 'Petrov');
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Monday', '10:00'),
            new Schedule\CancelDayRule('2021-01-11', '10:00'),
            new Schedule\CancelDayRule('2021-01-25', '10:00'),
        ]);
        $activity = new Activity('Chess', $schedule, $leader);
        $subscription = new \GroupLife\Core\Subscription\Activity($startTime, $period, $activity, $visitor);

        $visitorMapper = new VisitorMapper(self::$db);
        $visitorMapper->insert($visitor);
        $leaderMapper = new LeaderMapper(self::$db);
        $leaderMapper->insert($leader);
        $scheduleMapper = new ScheduleMapper(self::$db);
        $scheduleMapper->insert($schedule);
        $activityMapper = new ActivityMapper(self::$db);
        $activityMapper->insert($activity);
        $subscriptionMapper = new SubscriptionMapper(self::$db);
        $subscriptionMapper->insert($subscription);
    }
}
