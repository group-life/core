<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

use GroupLife\Core;

/**
 * FixedTime subscription allows one visit at exact day and time
 */
class FixedTime implements SubscriptionInterface
{
    private $dateTime;
    private $period;
    private $visitor;

    /**
     * @param \DateTimeImmutable $dateTime at what day and time a subscription is valid
     */
    public function __construct(\DateTimeImmutable $dateTime, Core\Visitor $visitor)
    {
        $this->dateTime = $dateTime;
        $this->period = new \DateInterval('P1D');
        $this->visitor = $visitor;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartDay(): \DateTimeImmutable
    {
        return $this->dateTime;
    }

    /**
     * @return \DateInterval
     */
    public function getPeriod(): \DateInterval
    {
        return $this->period;
    }

    /**
     * @param Core\Activity $activity
     */
    public function assertValid(Core\Activity $activity): void
    {
    }
}
