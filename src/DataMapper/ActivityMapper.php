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
        var_dump(json_encode($activity, JSON_PRETTY_PRINT));
        if (empty($activity->jsonSerialize()->schedule->jsonSerialize()->id)) {
            $this->scheduleMapper->insert($activity->jsonSerialize()->schedule);
        }
        if (empty($activity->jsonSerialize()->leader->jsonSerialize()['id'])) {
            $this->leaderMapper->insert($activity->jsonSerialize()->leader);
        }
        $this->connection->insert(
            'activity',
            [
                'name' => $activity->jsonSerialize()->name,
                'schedule_id' => $activity->jsonSerialize()->schedule->jsonSerialize()->id,
                'leader_id' => $activity->jsonSerialize()->leader->jsonSerialize()['id']
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
