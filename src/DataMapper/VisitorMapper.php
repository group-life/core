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

    /**
     * @param Visitor $visitor
     * @throws \Doctrine\DBAL\Exception
     */
    public function insert(Visitor $visitor)
    {
        $this->connection->insert('visitor', json_decode(json_encode($visitor), true));
        $visitor->persists((int)$this->connection->lastInsertId());
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function find(int $id): Visitor
    {
        $data = $this->connection->fetchAssociative('SELECT * FROM visitor WHERE id=?', [$id]);
        return new Visitor($data['name'], $data['surname']);
    }
}
