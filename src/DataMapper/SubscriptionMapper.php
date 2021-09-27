<?php

namespace GroupLife\Core\DataMapper;

use GroupLife\Core\Subscription\SubscriptionInterface;

class SubscriptionMapper
{
    private $connection;
    private $activityMapper;
    private $visitorMapper;

    public function __construct(
        \Doctrine\DBAL\Connection $connection,
        ActivityMapper $activityMapper,
        VisitorMapper $visitorMapper
    ) {
        $this->connection = $connection;
        $this->activityMapper = $activityMapper;
        $this->visitorMapper = $visitorMapper;
    }

    public function insert(SubscriptionInterface $subscription)
    {
    }

    public function find(int $id): SubscriptionInterface
    {
    }
}
