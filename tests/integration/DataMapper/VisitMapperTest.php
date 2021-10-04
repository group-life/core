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

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \GroupLife\Core\Exception\SavingToDbIsForbidden
     */
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
        $data = self::$db->fetchAllAssociative(
            'select * from visit where subscription_id = ?',
            [getDataObject($subscription)->id]
        );
        self::assertEquals(
            [
                [
                    'id' => getDataObject($activityVisits[0])->id,
                    'activity_id' => getDataObject($activity)->id,
                    'visitor_id' => getDataObject($visitor)->id,
                    'subscription_id' => getDataObject($subscription)->id,
                    'time' => getDataObject($activityVisits[0])->time->date,
                    'status' => getDataObject($activityVisits[0])->status,
                ],
                [
                    'id' => getDataObject($activityVisits[1])->id,
                    'activity_id' => getDataObject($activity)->id,
                    'visitor_id' => getDataObject($visitor)->id,
                    'subscription_id' => getDataObject($subscription)->id,
                    'time' => getDataObject($activityVisits[1])->time->date,
                    'status' => getDataObject($activityVisits[1])->status,
                ]
            ],
            $data
        );
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \GroupLife\Core\Exception\LoadFromDbImpossible
     */
    public function testFind()
    {
        $scheduleMapper = new ScheduleMapper(self::$db);
        $leaderMapper = new LeaderMapper(self::$db);
        $visitorMapper = new VisitorMapper(self::$db);
        $activityMapper = new ActivityMapper(self::$db);
        $subscriptionMapper = new SubscriptionMapper(self::$db);
        $visitMapper = new VisitMapper(self::$db);

        self::assertInstanceOf(Activity\Visit::class, $visitMapper->find(
            1,
            $activityMapper,
            $visitorMapper,
            $subscriptionMapper,
            $leaderMapper,
            $scheduleMapper
        ));
    }
}
