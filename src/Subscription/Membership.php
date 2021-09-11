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
     * @param \DateTimeImmutable $startDay first day of a subscription
     * @param \DateInterval $period period of validity
     */
    public function __construct(\DateTimeImmutable $startDay, \DateInterval $period)
    {
        $this->startDay = $startDay;
        $this->period = $period;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getStartDay(): \DateTimeImmutable
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
