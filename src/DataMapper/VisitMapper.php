<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Activity\Visit;
use GroupLife\Core\Exception\SavingToDbIsForbidden;

class VisitMapper
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    /**
     * @param \Doctrine\DBAL\Connection $connection
     */
    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param array $activityVisits
     * @throws SavingToDbIsForbidden
     * @throws \Doctrine\DBAL\Exception
     */
    public function insert(array $activityVisits)
    {
        foreach ($activityVisits as $visit) {
            if (!$visit instanceof Visit) {
                throw new SavingToDbIsForbidden('Can only save Visit object to visit DB table');
            }
            $data = getDataObject($visit);
            if (!empty($data->id)) {
                throw new SavingToDbIsForbidden('Visit Object is already in the database');
            }
            if (empty($data->activity->id)) {
                throw new SavingToDbIsForbidden('Activity object was not saved in the database');
            }
            if (empty($data->visitor->id)) {
                throw new SavingToDbIsForbidden('Visitor object was not saved in the database');
            }
            if (empty($data->subscription->id)) {
                throw new SavingToDbIsForbidden('Subscription object was not saved in the database');
            }

            $this->connection
                ->insert(
                    'visit',
                    [
                        'activity_id' => $data->activity->id,
                        'visitor_id' => $data->visitor->id,
                        'time' => $data->time->date,
                        'status' => $data->status,
                        'subscription_id' => $data->subscription->id
                    ]
                );
            $visit->persists((int)$this->connection->lastInsertId());
        }
    }

    /**
     * @param int $id
     * @param ActivityMapper $activityMapper
     * @param VisitorMapper $visitorMapper
     * @param SubscriptionMapper $subscriptionMapper
     * @param LeaderMapper $leaderMapper
     * @param ScheduleMapper $scheduleMapper
     * @return Visit
     * @throws \Doctrine\DBAL\Exception
     * @throws \GroupLife\Core\Exception\LoadFromDbImpossible
     */
    public function find(
        int $id,
        ActivityMapper $activityMapper,
        VisitorMapper $visitorMapper,
        SubscriptionMapper $subscriptionMapper,
        LeaderMapper $leaderMapper,
        ScheduleMapper $scheduleMapper
    ): Visit {
        $data = $this->connection->fetchAssociative('SELECT * FROM visit WHERE id = ?', [$id]);
        $time = new \DateTimeImmutable($data['time']);
        $activity = $activityMapper->find((int)$data['activity_id'], $leaderMapper, $scheduleMapper);
        $visitor = $visitorMapper->find((int)$data['visitor_id']);
        $subscription = $subscriptionMapper->find((int)$data['subscription_id'], $visitorMapper, $activityMapper);

        $visit = new Visit($time, $activity, $visitor, $subscription);
        $visit->persists((int)$data['id']);
        return $visit;
    }
}
