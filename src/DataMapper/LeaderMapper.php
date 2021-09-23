<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Leader;

class LeaderMapper
{
    private $connection;

    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Leader $leader
     * @throws \Doctrine\DBAL\Exception
     */
    public function insert(Leader $leader)
    {
        $this->connection->insert('leader', json_decode(json_encode($leader), true));
        $leader->persists((int)$this->connection->lastInsertId());
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function find(int $id): Leader
    {
        $data = $this->connection->fetchAssociative('SELECT * FROM leader WHERE id=?', [$id]);
        return new Leader($data['name'], $data['surname']);
    }
}
