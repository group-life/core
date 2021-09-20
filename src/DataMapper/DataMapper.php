<?php

namespace GroupLife\Core\DataMapper;

abstract class DataMapper
{
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function find(int $id)
    {
        $this->selectstmt()->execute([$id]);
        $array = $this->selectstmt()->fetchAll(\PDO::FETCH_ASSOC) ;
        $this->selectstmt()->closeCursor();

        if (!is_array($array)) {
            return null;
        }
        return $this->createObject($array);
    }

    public function createObject(array $raw)
    {
        $obj = $this->doCreateObject($raw);
        return $obj;
    }
    public function insert(object $obj)
    {
        $this->doInsert($obj);
    }
    abstract public function update(object $object);
    abstract protected function doCreateObject(array $array);
    abstract protected function doInsert(object $object);
    abstract protected function selectStmt(): \PDOStatement;
}
