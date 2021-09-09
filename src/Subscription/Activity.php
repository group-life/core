<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

class Activity implements SubscriptionInterface
{
    private $startDay;
    private $period;
    private $activity;

    public function __construct(
        \DateTime $startDay,
        \DateInterval $period,
        \GroupLife\Core\Activity $activity
    ) {
        $this->startDay = $startDay;
        $this->period = $period;
        $this->activity = $activity;
    }

    /**
     * @return \DateTime
     */
    public function getStartDay(): \DateTime
    {
        return $this->startDay;
    }

    /**
     * @return \DateInterval
     */
    public function getPeriod(): \DateInterval
    {
        return $this->period;
    }
}
