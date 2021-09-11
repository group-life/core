<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

use GroupLife\Core;

/**
 * Activity subscription allows to visit a specific activity
 */
class Activity implements SubscriptionInterface
{
    private $startDay;
    private $period;
    private $activity;

    /**
     * @param \DateTime $startDay first day of a subscription
     * @param \DateInterval $period period of validity
     * @param Core\Activity $activity what activity is allowed
     */
    public function __construct(
        \DateTime $startDay,
        \DateInterval $period,
        Core\Activity $activity
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
