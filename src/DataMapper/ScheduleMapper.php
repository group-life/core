<?php

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Schedule;

class ScheduleMapper
{
    private $connection;
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
            ->values(['data' => '?', 'schedule' => '?', 'type' => '?']);
    }

    public function insert(Schedule $object)
    {
        $this->insertSchedule->execute();
        $scheduleId = $this->connection->lastInsertId();
        $object->setId($scheduleId);
        foreach ($object->getData() as $rule) {
            $this->insertScheduleRule->setParameters([$rule->data, $scheduleId, $rule->type])->execute();
        }
    }
}
