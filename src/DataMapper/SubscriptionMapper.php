<?php

declare(strict_types=1);

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Subscription\SubscriptionInterface;

class SubscriptionMapper
{
    private $connection;

    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
    }

    public function insert(SubscriptionInterface $subscription)
    {
    }

    public function find(int $id): SubscriptionInterface
    {
    }
}
