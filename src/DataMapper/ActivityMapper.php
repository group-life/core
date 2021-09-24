<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Activity;

class ActivityMapper
{
    private $connection;
    private $scheduleMapper;
    private $leaderMapper;

    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
        $this->scheduleMapper = new ScheduleMapper($connection);
        $this->leaderMapper = new LeaderMapper($connection);
    }

    /**
     * @param Activity $activity
     * @throws \Doctrine\DBAL\Exception
     */
    public function insert(Activity $activity)
    {
        if (empty($activity->getData()->schedule->jsonSerialize()->id)) {
            $this->scheduleMapper->insert($activity->getData()->schedule);
        }
        if (empty($activity->getData()->leader->jsonSerialize()['id'])) {
            $this->leaderMapper->insert($activity->getData()->leader);
        }
        $this->connection->insert(
            'activity',
            [
                'name' => $activity->getData()->name,
                'schedule_id' => $activity->getData()->schedule->jsonSerialize()->id,
                'leader_id' => $activity->getData()->leader->jsonSerialize()['id']
            ]
        );
        $activity->persists((int)$this->connection->lastInsertId());
    }

    /**
     * @param int $id
     * @return Activity
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function find(int $id): Activity
    {
        $data = $this->connection->fetchAssociative('SELECT * FROM activity WHERE id=?', [$id]);
        $activity =  new Activity(
            $data['name'],
            $this->scheduleMapper->find((int)$data['schedule_id']),
            $this->leaderMapper->find((int)$data['leader_id'])
        );
        $activity->persists($id);
        return $activity;
    }
}
