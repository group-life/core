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
use GroupLife\Core\Subscription\SubscriptionInterface;
use GroupLife\Core\Test\TestCaseWithDb;
use GroupLife\Core\Visitor;

class SubscriptionMapperTest extends TestCaseWithDb
{
    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \GroupLife\Core\Exception\SavingToDbIsForbidden
     */
    public function testInsert()
    {
        $subscriptionActivity = self::newSubscriptionActivity();
        $subscriptionFixedTime = self::newSubscriptionFixedTime();
        $subscriptionMembership = self::newSubscriptionMembership();
        $subscriptionOneTime = self::newSubscriptionOneTime();

        $subscriptionMapper = new SubscriptionMapper(self::$db);

        $subscriptionMapper->insert($subscriptionActivity);
        $subscriptionMapper->insert($subscriptionFixedTime);
        $subscriptionMapper->insert($subscriptionMembership);
        $subscriptionMapper->insert($subscriptionOneTime);
        $sqlQuery = '
            select *
            from subscription
            where subscription.id = ?
            ';
        $data = getDataObject($subscriptionActivity);
        self::assertEquals(
            [
                'id' => $data->id,
                'activity' => $data->activity->id,
                'visitor' => $data->visitor->id,
                'type' => $data->type,
                'time_from' => $data->startDay->date,
                'period' => $data->period,
                'available' => '1'
            ],
            self::$db->fetchAssociative($sqlQuery, [$data->id])
        );
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \GroupLife\Core\Exception\LoadFromDbImpossible
     */
    public function testFind()
    {
        $subscriptionMapper = new SubscriptionMapper(self::$db);
        $newSubscription1 = $subscriptionMapper->find(1, new VisitorMapper(self::$db), new ActivityMapper(self::$db));
        self::assertInstanceOf(SubscriptionInterface::class, $newSubscription1);
        $newSubscription2 = $subscriptionMapper->find(2, new VisitorMapper(self::$db), new ActivityMapper(self::$db));
        self::assertInstanceOf(SubscriptionInterface::class, $newSubscription2);
        $newSubscription3 = $subscriptionMapper->find(3, new VisitorMapper(self::$db), new ActivityMapper(self::$db));
        self::assertInstanceOf(SubscriptionInterface::class, $newSubscription3);
        $newSubscription4 = $subscriptionMapper->find(4, new VisitorMapper(self::$db), new ActivityMapper(self::$db));
        self::assertInstanceOf(SubscriptionInterface::class, $newSubscription4);
    }

    /**
     * @return \GroupLife\Core\Subscription\Activity
     */
    public static function newSubscriptionActivity(): \GroupLife\Core\Subscription\Activity
    {
        $startTime = new \DateTimeImmutable('2021-01-01');
        $period = new \DateInterval('P1M');
        return new \GroupLife\Core\Subscription\Activity($startTime, $period, self::newActivity(), self::newVisitor());
    }

    /**
     * @return \GroupLife\Core\Subscription\FixedTime
     */
    public static function newSubscriptionFixedTime(): \GroupLife\Core\Subscription\FixedTime
    {
        $startTime = new \DateTimeImmutable('2021-01-01');
        return new \GroupLife\Core\Subscription\FixedTime($startTime, self::newVisitor());
    }

    /**
     * @return \GroupLife\Core\Subscription\Membership
     */
    public static function newSubscriptionMembership(): \GroupLife\Core\Subscription\Membership
    {
        $startTime = new \DateTimeImmutable('2021-01-01');
        $period = new \DateInterval('P1M');
        return new \GroupLife\Core\Subscription\Membership($startTime, $period, self::newVisitor());
    }

    /**
     * @return \GroupLife\Core\Subscription\OneTime
     */
    public static function newSubscriptionOneTime(): \GroupLife\Core\Subscription\OneTime
    {
        $startTime = new \DateTimeImmutable('2021-01-01');
        $period = new \DateInterval('P1M');
        return new \GroupLife\Core\Subscription\OneTime($startTime, $period, self::newVisitor());
    }

    /**
     * @return Visitor
     * @throws \Doctrine\DBAL\Exception
     */
    public static function newVisitor(): Visitor
    {
        $visitor = new Visitor('Ivan', 'Ivanov');
        $visitorMapper = new VisitorMapper(self::$db);
        $visitorMapper->insert($visitor);
        return $visitor;
    }

    /**
     * @return Leader
     * @throws \Doctrine\DBAL\Exception
     */
    public static function newLeader(): Leader
    {
        $leader = new Leader('Petr', 'Petrov');
        $leaderMapper = new LeaderMapper(self::$db);
        $leaderMapper->insert($leader);
        return $leader;
    }

    /**
     * @return Schedule
     */
    public static function newSchedule(): Schedule
    {
        $schedule = new Schedule([
            new Schedule\WeekdayRule('Monday', '10:00'),
            new Schedule\CancelDayRule('2021-01-11', '10:00'),
            new Schedule\CancelDayRule('2021-01-25', '10:00'),
        ]);
        $scheduleMapper = new ScheduleMapper(self::$db);
        $scheduleMapper->insert($schedule);
        return $schedule;
    }

    /**
     * @return Activity
     * @throws \Doctrine\DBAL\Exception
     * @throws \GroupLife\Core\Exception\SavingToDbIsForbidden
     */
    public static function newActivity(): Activity
    {
        $activity = new Activity('Chess', self::newSchedule(), self::newLeader());
        $activityMapper = new ActivityMapper(self::$db);
        $activityMapper->insert($activity);
        return $activity;
    }
}
