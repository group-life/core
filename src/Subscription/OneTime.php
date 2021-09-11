<?php

declare(strict_types=1);

namespace GroupLife\Core\Subscription;

/**
 * OneTime subscription allows one visit during period of its validity
 */
class OneTime implements SubscriptionInterface
{
    private $startDay;
    private $period;
    private $status = 'Available';

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
