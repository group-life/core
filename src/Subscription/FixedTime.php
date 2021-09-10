<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

class FixedTime implements SubscriptionInterface
{
    private $startDay;
    private $period;

    public function __construct(
        \DateTime $startDay
    ) {
        $this->startDay = $startDay;
        $this->period = new \DateInterval('P1D');
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
