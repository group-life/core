<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Schedule;

class ScheduleMapper
{
    private $connection;

    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
    }

    public function find(int $id): Schedule
    {
        $stmt = $this->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('schedule', 's')
            ->join('s', 'schedule_rule', 'sr', 's.id = sr.schedule_id')
            ->where('s.id = ?')
            ->orderBy('s.id');
        $stmt->setParameter('1', $id);
        $data = $stmt->execute()->fetchAllAssociative();

        $rules = [];
        foreach ($data as $rule) {
            $type = $rule['type'];
            $timeRule = array_values(json_decode($rule['data'], true));
            $rules[] = new $type($timeRule[0], $timeRule[1]);
        }
        $object = new Schedule($rules);
        $object->setId($id);
        return $object;
    }

    public function insert(Schedule $object)
    {
        $this->connection->insert('schedule', ['id' => null]);
        $scheduleId = $this->connection->lastInsertId();
        $object->setId((int)$scheduleId);

        foreach ($object->getData() as $rule) {
            $this->connection->insert(
                'schedule_rule',
                ['data' => $rule->data, 'schedule_id' => $scheduleId, 'type' => $rule->type]
            );
        }
    }
}
