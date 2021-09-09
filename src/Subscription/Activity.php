<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

use GroupLife\Core;

class Activity implements SubscriptionInterface
{
    private $startDay;
    private $period;
    private $activity;

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

    /**
    * @return Core\Activity|null
    */
    public function getActivity(): ?Core\Activity
    {
        return $this->activity;
    }
    /**
     * @return \DateTime|null
     */
    public function getVisitDay(): ?\DateTime
    {
        return null;
    }
    /**
     * @return int
     */
    public function getVisitsNumber(): int
    {
        return -1;
    }
}
