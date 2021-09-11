<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

/**
 * FixedTime subscription allows one visit at exact day and time
 */
class FixedTime implements SubscriptionInterface
{
    private $dateTime;
    private $period;

    /**
     * @param \DateTime $dateTime at what day and time a subscription is valid
     */
    public function __construct(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
        $this->period = new \DateInterval('P1D');
    }

    /**
     * @return \DateTime
     */
    public function getStartDay(): \DateTime
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
}
