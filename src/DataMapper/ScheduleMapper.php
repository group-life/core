<?php

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Schedule;

class ScheduleMapper extends DataMapper
{
    private $selectStmt;
    private $insertStmt;

    public function __construct(\PDO $pdo)
    {
        parent::__construct($pdo);
//        $this->selectStmt = $this->pdo->prepare(
//            "SELECT s.id, sr.type, sr.data FROM schedule s JOIN schedule_rule sr on s.id = sr.schedule WHERE s.id = ?"
//        );
        $this->insertStmt = $this->pdo->prepare(
            "INSERT INTO schedule (id) VALUES (null);"
        );

//        var_dump($this->selectStmt);
        var_dump($this->insertStmt);
    }

    public function update(object $object)
    {
    }

    protected function doCreateObject(array $array): Schedule
    {
        $rules = [];
        foreach ($array as $rule) {
            $type = $rule['type'];
            $timeRule = array_values(json_decode($rule['data'], true));
            $rules[] = new $type($timeRule[0], $timeRule[1]);
        }
        $object = new Schedule($rules);
        $object->setId($array[0]['id']);
        return $object;
    }

    protected function doInsert(object $object)
    {
        $this->insertStmt->execute();
        $id = $this->pdo->lastInsertId();
        $object->setId($id);
        foreach ($object->getData() as $rule) {
            $query = $this->pdo->prepare("INSERT INTO schedule_rule (data, schedule, type) VALUES (?,?,?);");
            $query->execute([$rule->data, $id, $rule->type]);
        }
    }

    protected function selectStmt(): \PDOStatement
    {
        return $this->selectStmt;
    }
}
