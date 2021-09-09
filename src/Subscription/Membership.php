<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

class Membership implements SubscriptionInterface
{
    private $startDay;
    private $period;

    public function __construct(
        \DateTime $startDay,
        \DateInterval $period
    ) {
        $this->startDay = $startDay;
        $this->period = $period;
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
