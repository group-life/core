<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

class VisitMapper
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    /**
     * @param \Doctrine\DBAL\Connection $connection
     */
    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
    }

    public function insert()
    {
    }

    public function find()
    {
    }
}
