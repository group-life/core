<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Activity;

class ActivityMapper
{
    private $connection;
    private $scheduleMapper;
    private $leaderMapper;

    public function __construct(
        \Doctrine\DBAL\Connection $connection,
        ScheduleMapper $scheduleMapper,
        LeaderMapper $leaderMapper
    ) {
        $this->connection = $connection;
        $this->scheduleMapper = $scheduleMapper;
        $this->leaderMapper = $leaderMapper;
    }

    /**
     * @param Activity $activity
     * @throws \Doctrine\DBAL\Exception
     */
    public function insert(Activity $activity)
    {
        $data = json_decode(json_encode($activity));
        if (empty($data->activity->id)) {
            $this->scheduleMapper->insert($activity->jsonSerialize()->schedule);
        }
        if (empty($data->leader->id)) {
            $this->leaderMapper->insert($activity->jsonSerialize()->leader);
        }
        $data = json_decode(json_encode($activity));
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
