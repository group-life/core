<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Visitor;

class VisitorMapper
{
    private $connection;

    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
    }

    public function insert(Visitor $visitor)
    {
        $this->connection->insert('visitor', json_decode(json_encode($visitor), true));
    }

    public function update(Visitor $object)
    {
    }

    public function find(int $id): Visitor
    {
    }
}
