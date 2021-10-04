<?php

namespace GroupLife\Core\tests\DataMapper;

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
use GroupLife\Core\Test\TestCaseWithDb;
use GroupLife\Core\Visitor;

class VisitMapperTest extends TestCaseWithDb
{

    public function testInsert()
    {

        $schedule = new Schedule(
            [
                new Schedule\WeekdayRule('Monday', '10:00'),
                new Schedule\CancelDayRule('2021-01-11', '10:00'),
                new Schedule\CancelDayRule('2021-01-25', '10:00')
            ]
        );
        $leader = new Leader('Ivan', 'Teacher');
        $activity = new Activity('Skiing', $schedule, $leader);
        $visitor = new Visitor('Petr', 'Student');
        $time = new \DateTimeImmutable('2021-01-04');
        $subscription = new Membership(new \DateTimeImmutable('2021-01-01'), new \DateInterval('P1M'), $visitor);
        $activityVisits = $activity->subscribe($visitor, $subscription);

        $scheduleMapper = new ScheduleMapper(self::$db);
        $leaderMapper = new LeaderMapper(self::$db);
        $visitorMapper = new VisitorMapper(self::$db);
        $activityMapper = new ActivityMapper(self::$db);
        $subscriptionMapper = new SubscriptionMapper(self::$db);
        $visitMapper = new VisitMapper(self::$db);

        $scheduleMapper->insert($schedule);
        $leaderMapper->insert($leader);
        $visitorMapper->insert($visitor);
        $activityMapper->insert($activity);
        $subscriptionMapper->insert($subscription);
        $visitMapper->insert($activityVisits);
    }

    public function testFind()
    {
    }
}
