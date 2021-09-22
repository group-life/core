<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Schedule;

class ScheduleMapper
{
    private $connection;
    private $findSchedule;
    private $insertSchedule;
    private $insertScheduleRule;

    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;

        $this->insertSchedule = $this->connection->createQueryBuilder();
        $this->insertSchedule
            ->insert('schedule')->values(['id' => 'null']);

        $this->insertScheduleRule = $this->connection->createQueryBuilder();
        $this->insertScheduleRule
            ->insert('schedule_rule')
            ->values(['data' => '?', 'schedule_id' => '?', 'type' => '?']);

        $this->findSchedule = $this->connection->createQueryBuilder();
        $this->findSchedule
            ->select('*')
            ->from('schedule', 's')
            ->join('s', 'schedule_rule', 'sr', 's.id = sr.schedule_id')
            ->where('s.id = ?')
            ->orderBy('s.id');
    }

    public function find(int $id): Schedule
    {
        $this->findSchedule->setParameter('1', $id);
        $data = $this->findSchedule->execute()->fetchAllAssociative();

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
        $this->insertSchedule->execute();
        $scheduleId = $this->connection->lastInsertId();
        $object->setId((int)$scheduleId);
        foreach ($object->getData() as $rule) {
            $this->insertScheduleRule->setParameters([$rule->data, $scheduleId, $rule->type])->execute();
        }
    }
}
