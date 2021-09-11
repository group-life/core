<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

/**
 * Membership subscription allows to visit any activity
 */
class Membership implements SubscriptionInterface
{
    private $startDay;
    private $period;

    /**
     * @param \DateTime $startDay first day of a subscription
     * @param \DateInterval $period period of validity
     */
    public function __construct(\DateTime $startDay, \DateInterval $period)
    {
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
