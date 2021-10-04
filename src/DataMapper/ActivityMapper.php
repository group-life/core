<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Activity;
use GroupLife\Core\Exception\SavingToDbIsForbidden;

class ActivityMapper
{
    private $connection;

    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Activity $activity
     * @throws SavingToDbIsForbidden
     * @throws \Doctrine\DBAL\Exception
     */
    public function insert(Activity $activity)
    {
        $data = getDataObject($activity);
        if (!empty($data->id)) {
            throw new SavingToDbIsForbidden('Object is already in the database');
        }
        if (empty($data->schedule->id)) {
            throw new SavingToDbIsForbidden('Schedule object was not saved in the database');
        }
        if (empty($data->leader->id)) {
            throw new SavingToDbIsForbidden('Leader object was not saved in the database');
        }

        $this->connection->insert(
            'activity',
            [
                'name' => $data->name,
                'schedule_id' => $data->schedule->id,
                'leader_id' => $data->leader->id
            ]
        );
        $activity->persists((int)$this->connection->lastInsertId());
    }

    /**
     * @param int $id
     * @param LeaderMapper $leaderMapper
     * @param ScheduleMapper $scheduleMapper
     * @return Activity
     * @throws \Doctrine\DBAL\Exception
     */
    public function find(int $id, LeaderMapper $leaderMapper, ScheduleMapper $scheduleMapper): Activity
    {
        $data = $this->connection->fetchAssociative('SELECT * FROM activity WHERE id=?', [$id]);
        $activity =  new Activity(
            $data['name'],
            $scheduleMapper->find((int)$data['schedule_id']),
            $leaderMapper->find((int)$data['leader_id'])
        );
        $activity->persists($id);
        return $activity;
    }
}
