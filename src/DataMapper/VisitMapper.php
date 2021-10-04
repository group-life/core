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

    public function find()
    {
    }
}
