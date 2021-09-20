<?php

namespace GroupLife\Core\Mapper;

abstract class Mapper
{
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
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
    abstract protected function doCreateObject(array $raw);
    abstract protected function doInsert(object $object);
}
