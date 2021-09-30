<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Exception\LoadFromDbImpossible;
use GroupLife\Core\Exception\SavingToDbIsForbidden;
use GroupLife\Core\Subscription\SubscriptionInterface;

class SubscriptionMapper
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
     * @param SubscriptionInterface $subscription
     * @throws SavingToDbIsForbidden
     * @throws \Doctrine\DBAL\Exception
     */
    public function insert(SubscriptionInterface $subscription)
    {
        $data = getDataObject($subscription);
        if (!empty($data->id)) {
            throw new SavingToDbIsForbidden('Object is already in the database');
        }
        if (!empty($data->activity)) {
            if (empty($data->activity->id)) {
                throw new SavingToDbIsForbidden('Activity object was not saved in the database');
            }
        }
        if (empty($data->visitor->id)) {
            throw new SavingToDbIsForbidden('Visitor object was not saved in the database');
        }
        $this->connection
            ->insert(
                'subscription',
                [
                    'activity' => empty($data->activity) ? null : $data->activity->id,
                    'visitor' => $data->visitor->id,
                    'type' => $data->type,
                    'time_from' => $data->startDay->date,
                    'period' => $data->period,
                    'available' => $data->status ?? true,
                ]
            );
        $subscription->persists((int)$this->connection->lastInsertId());
    }

    /**
     * @param int $id
     * @param VisitorMapper $visitorMapper
     * @param ActivityMapper $activityMapper
     * @return SubscriptionInterface
     * @throws LoadFromDbImpossible
     * @throws \Doctrine\DBAL\Exception
     */
    public function find(
        int $id,
        VisitorMapper $visitorMapper,
        ActivityMapper $activityMapper
    ): SubscriptionInterface {

        $data = $this->connection->fetchAssociative('SELECT * FROM subscription WHERE id=?', [$id]);
        $subscriptionType = $data['type'];
        $subscriptionTime = new \DateTimeImmutable($data['time_from']);
        $subscriptionPeriod = getDateInterval((int)$data['period']);
        $subscriptionVisitor = $visitorMapper->find((int)$data['visitor']);

        switch ($subscriptionType) {
            case 'GroupLife\Core\Subscription\Activity':
                $newSubscription = new $subscriptionType(
                    $subscriptionTime,
                    $subscriptionPeriod,
                    $activityMapper->find(
                        (int)$data['activity'],
                        new LeaderMapper($this->connection),
                        new ScheduleMapper($this->connection)
                    ),
                    $subscriptionVisitor
                );
                $newSubscription->persists($id);
                break;
            case 'GroupLife\Core\Subscription\Membership':
                $newSubscription = new $subscriptionType(
                    $subscriptionTime,
                    $subscriptionPeriod,
                    $subscriptionVisitor
                );
                break;
            case 'GroupLife\Core\Subscription\FixedTime':
                $newSubscription = new $subscriptionType(
                    $subscriptionTime,
                    $subscriptionVisitor
                );
                break;
            case 'GroupLife\Core\Subscription\OneTime':
                $newSubscription = new $subscriptionType(
                    $subscriptionTime,
                    $subscriptionPeriod,
                    $subscriptionVisitor,
                    $data['available'] === 'true'
                );
                $newSubscription->persists($id);
                break;
            default:
                throw new LoadFromDbImpossible('Unexpected subscription type');
        }
        $newSubscription->persists($id);
        return $newSubscription;
    }
}
